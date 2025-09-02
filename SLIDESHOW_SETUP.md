# Slideshow Setup Guide

## Overview

The home page now includes a slideshow feature that displays images from an album named "slideshow". This creates a dynamic, engaging introduction to your website.

## Setup Steps

### 1. Create the "slideshow" Album

1. Go to your admin panel: `http://127.0.0.1:8000/admin/albums`
2. Click "Create New Album"
3. Set the following details:
    - **Name**: `slideshow`
    - **Description**: `Home page slideshow images`
    - **Type**: `photo`
    - **Is Public**: ✅ Checked
    - **Is Featured**: ✅ Checked (optional)
4. Click "Create Album"

### 2. Add Images to the Slideshow Album

1. Go to `http://127.0.0.1:8000/admin/media`
2. Click "Create New Media"
3. For each image:
    - **Type**: Select `photo`
    - **Album**: Choose "slideshow" from the dropdown
    - **Title**: Give it a descriptive title (e.g., "Choir Performance 2024")
    - **Description**: Add a brief description (optional)
    - **Upload**: Select your image file
    - **Is Public**: ✅ Checked
    - **Is Featured**: ✅ Checked (optional)
4. Click "Create Media"
5. Repeat for additional images

### 3. Organize Slideshow Order

1. In the media edit page, you can set a **Sort Order** number
2. Lower numbers appear first (1, 2, 3, etc.)
3. This controls the sequence of images in the slideshow

## Features

### Automatic Slideshow

-   Images automatically advance every 5 seconds
-   Smooth fade transitions between slides
-   Responsive design for all devices

### Navigation Controls

-   **Left/Right arrows** for manual navigation
-   **Dot indicators** at the bottom
-   **Click any dot** to jump to a specific slide
-   **Keyboard shortcuts**: Left/Right arrow keys

### Fallback Display

-   If no slideshow images exist, a hero section is displayed instead
-   Ensures the page always looks good

## Customization

### Image Requirements

-   **Format**: JPG, PNG, GIF, WebP
-   **Size**: Recommended 1920x1080 or larger
-   **Aspect Ratio**: 16:9 or similar widescreen format works best
-   **File Size**: Keep under 5MB for optimal performance

### Styling

-   Images are automatically cropped to fit the slideshow area
-   Dark overlay ensures text readability
-   Responsive design adapts to different screen sizes

## Troubleshooting

### Slideshow Not Showing

1. Check that the album is named exactly "slideshow" (case-sensitive)
2. Verify the album is marked as "Public"
3. Ensure images are marked as "Public"
4. Check that images are of type "photo"

### Images Not Loading

1. Verify file uploads completed successfully
2. Check storage permissions
3. Ensure images are in supported formats
4. Verify file paths in the database

### Performance Issues

1. Optimize image sizes (compress if needed)
2. Use appropriate image formats (WebP for better compression)
3. Consider lazy loading for many images

## Example Album Structure

```
Album: slideshow
├── Image 1: "Choir Performance" (Sort Order: 1)
├── Image 2: "Rehearsal Session" (Sort Order: 2)
├── Image 3: "Concert Hall" (Sort Order: 3)
└── Image 4: "Community Event" (Sort Order: 4)
```

## Testing

1. Visit your home page: `http://127.0.0.1:8000`
2. The slideshow should appear at the top
3. Test navigation controls
4. Verify automatic advancement
5. Check responsive behavior on mobile devices

## Support

If you encounter issues:

1. Check the browser console for JavaScript errors
2. Verify Laravel logs for backend errors
3. Ensure all required models and relationships are working
4. Test with a simple image first before adding many
