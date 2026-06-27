import { test, expect } from '@playwright/test';

test('admin can login and create a post through JS CMS app', async ({ page }) => {
    await page.goto('/login');

    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'admin');
    await page.click('button:has-text("Login")');

    await page.goto('/cms-app');

    await page.fill('#api-title', 'Playwright API Post');
    await page.fill('#api-body', 'This post was created through the JavaScript API form.');
    await page.selectOption('#api-filter', 'warm');

    await page.click('button:has-text("Publish")');

    await expect(page.locator('text=Your post was created')).toBeVisible({
        timeout: 10000,
    });

    await expect(page.locator('text=Playwright API Post')).toBeVisible();
});