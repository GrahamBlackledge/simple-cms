export function sanitizeText(value) {
    // remove angle brackets and extra spaces from text input
    return String(value || '')
        .replace(/[<>]/g, '')
        .trim();
}

export function validatePostInput({ title, body, image }) {
    const errors = {};

    // check the main post fields before sending to the API
    if (!title || title.length < 3) {
        errors.title = 'Title must be at least 3 characters.';
    }

    if (title && title.length > 255) {
        errors.title = 'Title must be less than 255 characters.';
    }

    if (!body || body.length < 5) {
        errors.body = 'Description must be at least 5 characters.';
    }

    if (body && body.length > 2000) {
        errors.body = 'Description must be less than 2000 characters.';
    }

    if (image && image.size > 3000 * 1024) {
        errors.image = 'Image must be smaller than 3MB.';
    }

    const allowedImageTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    // only allow the image file types used by the app
    if (image && !allowedImageTypes.includes(image.type)) {
        errors.image = 'Image must be JPG, PNG or WEBP.';
    }

    return {
        isValid: Object.keys(errors).length === 0,
        errors,
    };
}