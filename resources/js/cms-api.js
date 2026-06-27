import { sanitizeText, validatePostInput } from './utils/validation';

const postForm = document.querySelector('#api-post-form');
const postsList = document.querySelector('#posts-list');
const apiMessage = document.querySelector('#api-message');
const loadLatestPostsButton = document.querySelector('#load-latest-posts');
const loadMyPostsButton = document.querySelector('#load-my-posts');

const csrfToken = document.querySelector('input[name="_token"]')?.value;

const appState = {
    isLoggedIn: Boolean(csrfToken),
    posts: [],
};

function showMessage(message, type = 'success') {
    // show a success or error message on the page
    apiMessage.className = type === 'success'
        ? 'mb-4 bg-green-500 text-white px-3 py-2 rounded-md'
        : 'mb-4 bg-red-500 text-white px-3 py-2 rounded-md';

    apiMessage.textContent = message;
    apiMessage.classList.remove('hidden');
}

function clearErrors() {
    // clear old form errors before checking again
    ['title', 'body', 'image'].forEach((fieldName) => {
        const errorElement = document.querySelector(`#${fieldName}-error`);

        if (errorElement) {
            errorElement.textContent = '';
            errorElement.classList.add('hidden');
        }
    });
}

function showErrors(errors) {
    // show validation errors under the correct inputs
    Object.entries(errors).forEach(([fieldName, message]) => {
        const errorElement = document.querySelector(`#${fieldName}-error`);

        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
    });
}

function imageUrl(post) {
    if (post.image) {
        return `/storage/${post.image}`;
    }

    return '/img/avatar5.png';
}

function renderPosts(posts) {
    // clear the current list then display the posts from the API
    appState.posts = posts;
    postsList.innerHTML = '';

    if (!posts.length) {
        postsList.innerHTML = '<p class="text-sm text-slate-600">No posts found.</p>';
        return;
    }

    posts.forEach((post) => {
        const postCard = document.createElement('article');
        postCard.className = 'card';

        postCard.innerHTML = `
            <h2 class="font-bold text-xl mb-2">${sanitizeText(post.title)}</h2>
            <img src="${imageUrl(post)}" alt="" class="w-full h-48 object-cover rounded-md mb-4">
            <p class="text-sm mb-2">${sanitizeText(post.body).slice(0, 160)}...</p>
            <p class="text-xs text-slate-500 mb-2">Filter: ${sanitizeText(post.filter || 'none')}</p>
            <p class="text-xs text-slate-500 mb-4">Author: ${sanitizeText(post.user?.username || 'Unknown')}</p>
            <button class="delete-post bg-red-500 text-white px-2 py-1 rounded-md text-xs" data-id="${post.id}">
                Delete
            </button>
        `;

        postsList.appendChild(postCard);
    });
}

async function apiFetch(url, options = {}) {
    // reusable fetch function for the CMS API
    const response = await fetch(url, {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': `Bearer ${csrfToken}`,
            ...options.headers,
        },
        ...options,
    });

    const data = await response.json();

    if (!response.ok) {
        throw data;
    }

    return data;
}

async function loadLatestPosts() {
    try {
        const data = await apiFetch('/cms-api/posts/latest');
        renderPosts(data.posts);
    } catch (error) {
        showMessage('Could not load latest posts.', 'error');
    }
}

async function loadMyPosts() {
    try {
        const data = await apiFetch('/cms-api/posts/mine');
        renderPosts(data.posts);
    } catch (error) {
        showMessage('Could not load your posts.', 'error');
    }
}

async function createPost(event) {
    event.preventDefault();
    clearErrors();

    const titleInput = document.querySelector('#api-title');
    const bodyInput = document.querySelector('#api-body');
    const filterInput = document.querySelector('#api-filter');
    const imageInput = document.querySelector('#api-image');

    const title = sanitizeText(titleInput.value);
    const body = sanitizeText(bodyInput.value);
    const filter = sanitizeText(filterInput.value);
    const image = imageInput.files[0];

    // check input before sending the form to Laravel
    const validationResult = validatePostInput({ title, body, image });

    if (!validationResult.isValid) {
        showErrors(validationResult.errors);
        showMessage('Please fix the form errors.', 'error');
        return;
    }

    const formData = new FormData();
    formData.append('title', title);
    formData.append('body', body);
    formData.append('filter', filter);

    if (image) {
        formData.append('image', image);
    }

    try {
        // send the new post to the API
        const data = await apiFetch('/cms-api/posts', {
            method: 'POST',
            body: formData,
        });

        postForm.reset();
        showMessage(data.message);
        await loadMyPosts();
    } catch (error) {
        if (error.errors) {
            showErrors(error.errors);
        }

        showMessage('Post could not be created.', 'error');
    }
}

async function deletePost(postId) {
    try {
        // delete selected post through the API
        const data = await apiFetch(`/cms-api/posts/${postId}`, {
            method: 'DELETE',
        });

        showMessage(data.message);
        await loadMyPosts();
    } catch (error) {
        showMessage('Post could not be deleted.', 'error');
    }
}

postForm?.addEventListener('submit', createPost);
loadLatestPostsButton?.addEventListener('click', loadLatestPosts);
loadMyPostsButton?.addEventListener('click', loadMyPosts);

// handle delete buttons added when posts are rendered
postsList?.addEventListener('click', (event) => {
    const deleteButton = event.target.closest('.delete-post');

    if (deleteButton) {
        deletePost(deleteButton.dataset.id);
    }
});

loadLatestPosts();