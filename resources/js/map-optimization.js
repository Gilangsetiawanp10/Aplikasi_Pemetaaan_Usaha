// Map Optimization Utilities
class MapOptimizer {
    constructor() {
        this.viewportBounds = null;
        this.visibilityCache = new Map();
        this.renderQueue = [];
        this.isRendering = false;
    }

    // Check if point is in current viewport
    isInViewport(coordinates, bounds) {
        const [lng, lat] = coordinates;
        return (
            lng >= bounds.getWest() &&
            lng <= bounds.getEast() &&
            lat >= bounds.getSouth() &&
            lat <= bounds.getNorth()
        );
    }

    // Filter data based on current viewport
    filterByViewport(data, map) {
        const bounds = map.getBounds();
        return data.filter(
            (item) =>
                item.coordinates && this.isInViewport(item.coordinates, bounds)
        );
    }

    // Batch rendering for better performance
    batchRender(renderFunction, data, batchSize = 50) {
        if (this.isRendering) return;

        this.isRendering = true;
        let index = 0;

        const processBatch = () => {
            const batch = data.slice(index, index + batchSize);
            if (batch.length === 0) {
                this.isRendering = false;
                return;
            }

            batch.forEach((item) => renderFunction(item));
            index += batchSize;

            // Use requestAnimationFrame for smooth rendering
            requestAnimationFrame(processBatch);
        };

        processBatch();
    }

    // Debounce function for performance
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Throttle function for scroll/zoom events
    throttle(func, limit) {
        let inThrottle;
        return function () {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => (inThrottle = false), limit);
            }
        };
    }

    // Progressive loading based on priority
    progressiveLoad(data, priorityField, callback) {
        // Sort by priority (highest first)
        const sortedData = [...data].sort(
            (a, b) =>
                (parseInt(b[priorityField]) || 0) -
                (parseInt(a[priorityField]) || 0)
        );

        // Load in chunks
        const loadChunk = (index, chunkSize = 20) => {
            if (index >= sortedData.length) return;

            const chunk = sortedData.slice(index, index + chunkSize);
            callback(chunk);

            // Continue with next chunk after a small delay
            setTimeout(() => loadChunk(index + chunkSize, chunkSize), 10);
        };

        loadChunk(0);
    }
}

// Export for use in main map script
window.MapOptimizer = MapOptimizer;
