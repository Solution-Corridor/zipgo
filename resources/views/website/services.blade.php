<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Services - ZipGo</title>
    <meta name="description" content="Browse all services offered by ZipGo">
    @include('includes.header_links')
<style>
    .services-page {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }

    .page-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .page-header p {
        color: #6b7280;
    }

    /* 3 cards per row */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;  /* reduced gap */
    }

    @media (max-width: 900px) {
        .services-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .services-grid {
            grid-template-columns: 1fr;
        }
    }

    .service-card {
        background: #fff;
        border-radius: 16px;  /* slightly smaller radius */
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid #f0f0f0;
    }

    .service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
    }

    /* Reduced image height */
    .service-img {
        width: 100%;
        aspect-ratio: 16 / 9;   /* shorter than 4/3 */
        object-fit: cover;
        background: #f9fafb;
    }

    /* Tighter content padding */
    .service-content {
        padding: 0.9rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .service-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.4rem;
        line-height: 1.3;
    }

    .service-detail {
        font-size: 0.85rem;
        color: #6c757d;
        line-height: 1.4;
        margin-bottom: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;   /* show only 2 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-experts {
        display: inline-block;
        background: #131B2B;
        color: white;
        padding: 0.4rem 0.9rem;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.8rem;
        transition: background 0.2s;
        text-align: center;
        align-self: flex-start;
    }

    .btn-experts:hover {
        background: #0b1220;
    }

    .see-more-container {
        text-align: center;
        margin-top: 2rem;
    }

    .btn-see-more {
        background: transparent;
        border: 2px solid #131B2B;
        color: #131B2B;
        padding: 0.6rem 1.8rem;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-see-more:hover {
        background: #131B2B;
        color: white;
    }

    .loader {
        display: none;
        justify-content: center;
        margin: 20px 0;
    }

    .spinner {
        width: 36px;
        height: 36px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #131B2B;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 16px;
        color: #6c757d;
    }

    .service-card {
        opacity: 0;
        transform: translateY(15px);
        animation: fadeUp 0.3s ease forwards;
    }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</head>

<body>
    @include('includes.navbar')

    <div class="services-page mt-5">
        <div class="page-header">
            <h1>Our Services</h1>
            <p>Professional services at your doorstep</p>
        </div>

        <div class="services-grid" id="servicesGrid">
            <!-- Services loaded via AJAX -->
        </div>

        <div class="loader" id="loader">
            <div class="spinner"></div>
        </div>

        <div class="see-more-container" id="seeMoreContainer">
            <button class="btn-see-more" id="seeMoreBtn">See More</button>
        </div>
    </div>

    @include('includes.footer')
    @include('includes.footer_links')

    <script>
        let currentOffset = 0;
        let isLoading = false;
        let hasMore = true;

        const servicesGrid = document.getElementById('servicesGrid');
        const seeMoreBtn = document.getElementById('seeMoreBtn');
        const seeMoreContainer = document.getElementById('seeMoreContainer');
        const loader = document.getElementById('loader');

        async function loadServices(offset) {
            if (isLoading || !hasMore) return;
            isLoading = true;
            loader.style.display = 'flex';

            try {
                const response = await fetch(`/services/load-more?offset=${offset}`);
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                const data = await response.json();

                if (data.services && data.services.length > 0) {
                    appendServices(data.services);
                    currentOffset = data.nextOffset;
                    hasMore = data.hasMore;

                    if (!hasMore) {
                        seeMoreBtn.textContent = 'All Services Loaded';
                        seeMoreBtn.disabled = true;
                        seeMoreBtn.style.opacity = '0.6';
                        seeMoreBtn.style.cursor = 'default';
                    }
                } else {
                    if (offset === 0) {
                        servicesGrid.innerHTML = '<div class="empty-state">No services available yet.</div>';
                    }
                    seeMoreContainer.style.display = 'none';
                    hasMore = false;
                }
            } catch (error) {
                console.error('Error loading services:', error);
                servicesGrid.innerHTML = `<div class="empty-state">Error loading services: ${error.message}</div>`;
            } finally {
                isLoading = false;
                loader.style.display = 'none';
            }
        }

        function appendServices(services) {
            services.forEach(service => {
                const card = document.createElement('div');
                card.className = 'service-card';

                const imgHtml = service.pic
                    ? `<img src="/${service.pic}" class="service-img" alt="${service.name}" 
                         onerror="this.onerror=null; this.src='/assets/images/favicon.png';">`
                    : `<div class="service-img" style="background:#f0f2f5; display:flex; align-items:center; justify-content:center;">
                           <span style="font-size:3rem;">🔧</span>
                       </div>`;

                card.innerHTML = `
                    ${imgHtml}
                    <div class="service-content">
                        <div class="service-name">${escapeHtml(service.name)}</div>
                        <div class="service-detail">${escapeHtml(service.short_detail || 'Learn more about this service')}</div>
                        <a href="/service/${service.slug}" class="btn-experts">See Experts →</a>
                    </div>
                `;
                servicesGrid.appendChild(card);
            });
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        loadServices(0);

        seeMoreBtn.addEventListener('click', () => {
            if (hasMore && !isLoading) loadServices(currentOffset);
        });
    </script>
</body>

</html>