export default {
    async fetch(request, env, ctx) {
        const url = new URL(request.url);

        const ALLOWED_ORIGIN = "https://upsidefrown.fisherevans.com";
        const origin = request.headers.get("Origin");

        // Handle CORS preflight
        if (request.method === "OPTIONS") {
            // Only allow your site to preflight
            if (origin !== ALLOWED_ORIGIN) {
                return new Response(null, { status: 403 });
            }

            return new Response(null, {
                status: 204,
                headers: {
                    "Access-Control-Allow-Origin": ALLOWED_ORIGIN,
                    "Access-Control-Allow-Methods": "GET, OPTIONS",
                    "Access-Control-Allow-Headers": "Content-Type",
                    "Access-Control-Max-Age": "86400",
                    "Vary": "Origin",
                },
            });
        }

        if (request.method !== "GET") {
            return new Response("Method Not Allowed", { status: 405 });
        }

        // If this request is coming from a browser, lock it to your origin.
        // (curl / server-side requests have no Origin header; we allow those.)
        if (origin && origin !== ALLOWED_ORIGIN) {
            return new Response("Forbidden", { status: 403 });
        }

        // Expected path form (recommended):
        // /api/yahoo/chart/{TICKER}
        //
        // If you route the worker differently, adjust this parsing accordingly.
        const parts = url.pathname.split("/").filter(Boolean);

        // Find ".../chart/{ticker}"
        const chartIndex = parts.indexOf("chart");
        if (chartIndex === -1 || chartIndex + 1 >= parts.length) {
            return new Response("Not Found", { status: 404 });
        }

        const ticker = parts[chartIndex + 1];
        if (!/^[A-Za-z0-9.=^_-]+$/.test(ticker)) {
            return new Response("Invalid ticker", { status: 400 });
        }

        const interval = url.searchParams.get("interval") || "1d";
        const range = url.searchParams.get("range") || "1d";

        // Basic input validation (keeps it from being used as an open proxy)
        if (!/^[0-9]+[mhdwk]$/.test(interval)) {
            return new Response("Invalid interval", { status: 400 });
        }
        if (!/^[0-9]+[dmy]$/.test(range) && !["1d", "5d", "1mo", "6mo", "1y", "5y", "max"].includes(range)) {
            return new Response("Invalid range", { status: 400 });
        }

        const yahooUrl = new URL(`https://query1.finance.yahoo.com/v8/finance/chart/${ticker}`);
        yahooUrl.searchParams.set("interval", interval);
        yahooUrl.searchParams.set("range", range);

        // Short cache helps a lot and reduces Yahoo + your Worker load
        const cacheTtlSeconds = 15;

        const upstreamResp = await fetch(yahooUrl.toString(), {
            headers: {
                // Setting UA sometimes helps with flaky upstream behavior.
                "User-Agent": "Mozilla/5.0 (compatible; upsidefrown-worker)",
                "Accept": "application/json,text/plain,*/*",
            },
            cf: {
                cacheEverything: true,
                cacheTtl: cacheTtlSeconds,
            },
        });

        const headers = new Headers(upstreamResp.headers);

        // Ensure correct content type (Yahoo usually sets it, but keep it explicit)
        headers.set("Content-Type", "application/json; charset=utf-8");
        headers.set("Cache-Control", `public, max-age=${cacheTtlSeconds}`);

        // Only add CORS headers when the request came from the browser.
        // (If your SPA calls same-origin, this is still fine.)
        if (origin === ALLOWED_ORIGIN) {
            headers.set("Access-Control-Allow-Origin", ALLOWED_ORIGIN);
            headers.set("Vary", "Origin");
        }

        return new Response(upstreamResp.body, {
            status: upstreamResp.status,
            headers,
        });
    },
};