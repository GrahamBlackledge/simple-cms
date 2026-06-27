import { describe, expect, test } from 'vitest';
import { sanitizeText, validatePostInput } from '../../resources/js/utils/validation';

describe('sanitizeText', () => {
    test('removes angle brackets', () => {
        const result = sanitizeText('<script>alert("bad")</script>');

        expect(result).not.toContain('<');
        expect(result).not.toContain('>');
    });

    test('trims spaces', () => {
        const result = sanitizeText('   Hello world   ');

        expect(result).toBe('Hello world');
    });
});

describe('validatePostInput', () => {
    test('requires a title', () => {
        const result = validatePostInput({
            title: '',
            body: 'Valid body text',
            image: null,
        });

        expect(result.isValid).toBe(false);
        expect(result.errors.title).toBeTruthy();
    });

    test('requires a body', () => {
        const result = validatePostInput({
            title: 'Valid title',
            body: '',
            image: null,
        });

        expect(result.isValid).toBe(false);
        expect(result.errors.body).toBeTruthy();
    });

    test('accepts valid input', () => {
        const result = validatePostInput({
            title: 'Valid title',
            body: 'This is a valid body.',
            image: null,
        });

        expect(result.isValid).toBe(true);
    });
});