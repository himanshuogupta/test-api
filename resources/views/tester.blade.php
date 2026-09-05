<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Tester</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #1e293b;
            --border: #334155;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --get: #0ea5e9;
            --post: #22c55e;
            --error: #f87171;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            padding: 24px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 1.5rem;
        }

        p {
            margin: 0 0 24px;
            color: var(--muted);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }

        button.request {
            appearance: none;
            border: 1px solid var(--border);
            background: var(--panel);
            color: var(--text);
            border-radius: 10px;
            padding: 16px;
            text-align: left;
            cursor: pointer;
            width: 100%;
        }

        button.request:hover,
        button.request:focus-visible {
            outline: 2px solid #64748b;
            outline-offset: 2px;
        }

        button.request.active {
            outline: 2px solid #e2e8f0;
        }

        button.request:disabled {
            opacity: 0.7;
            cursor: wait;
        }

        .method {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 2px 8px;
            border-radius: 999px;
            margin-bottom: 8px;
        }

        .method.get { background: rgba(14, 165, 233, 0.2); color: var(--get); }
        .method.post { background: rgba(34, 197, 94, 0.2); color: var(--post); }

        .url {
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            font-size: 0.9rem;
        }

        .result {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
        }

        .result-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            color: var(--muted);
            font-size: 0.875rem;
            margin-bottom: 12px;
        }

        .ok { color: var(--post); }
        .fail { color: var(--error); }

        pre {
            margin: 0;
            overflow: auto;
            white-space: pre-wrap;
            word-break: break-word;
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <h1>API Tester</h1>
    <p>Trigger each of the six test endpoints and inspect the JSON response.</p>

    <div class="grid">
        <button class="request" type="button" data-method="GET" data-url="/api/test?foo=bar">
            <span class="method get">GET</span>
            <div class="url">/api/test</div>
        </button>
        <button class="request" type="button" data-method="POST" data-url="/api/test" data-body='{"name":"Himanshu","message":"Hello from POST"}'>
            <span class="method post">POST</span>
            <div class="url">/api/test</div>
        </button>
        <button class="request" type="button" data-method="GET" data-url="/api/echo?q=hello">
            <span class="method get">GET</span>
            <div class="url">/api/echo</div>
        </button>
        <button class="request" type="button" data-method="POST" data-url="/api/echo" data-body='{"value":"repeat this"}'>
            <span class="method post">POST</span>
            <div class="url">/api/echo</div>
        </button>
        <button class="request" type="button" data-method="GET" data-url="/api/ping">
            <span class="method get">GET</span>
            <div class="url">/api/ping</div>
        </button>
        <button class="request" type="button" data-method="POST" data-url="/api/ping" data-body='{"id":42,"note":"check ping"}'>
            <span class="method post">POST</span>
            <div class="url">/api/ping</div>
        </button>
    </div>

    <section class="result" aria-live="polite">
        <div class="result-meta">
            <span id="result-status">No request yet</span>
            <span id="result-url"></span>
        </div>
        <pre id="result-body">Click a button to send a request.</pre>
    </section>

    <script>
        const statusEl = document.getElementById('result-status');
        const urlEl = document.getElementById('result-url');
        const bodyEl = document.getElementById('result-body');
        const buttons = document.querySelectorAll('button.request');

        async function sendRequest(button) {
            const method = button.dataset.method;
            const url = button.dataset.url;
            const body = button.dataset.body;

            buttons.forEach((item) => {
                item.disabled = true;
                item.classList.remove('active');
            });
            button.classList.add('active');

            statusEl.textContent = 'Sending…';
            statusEl.className = '';
            urlEl.textContent = method + ' ' + url;
            bodyEl.textContent = '';

            try {
                const options = {
                    method,
                    headers: {
                        'Accept': 'application/json',
                    },
                };

                if (method === 'POST') {
                    options.headers['Content-Type'] = 'application/json';
                    options.body = body;
                }

                const response = await fetch(url, options);
                const text = await response.text();
                let formatted = text;

                try {
                    formatted = JSON.stringify(JSON.parse(text), null, 2);
                } catch (error) {
                    // Keep raw text when the response is not JSON.
                }

                statusEl.textContent = response.status + ' ' + response.statusText;
                statusEl.className = response.ok ? 'ok' : 'fail';
                bodyEl.textContent = formatted;
            } catch (error) {
                statusEl.textContent = 'Request failed';
                statusEl.className = 'fail';
                bodyEl.textContent = error.message;
            } finally {
                buttons.forEach((item) => {
                    item.disabled = false;
                });
            }
        }

        buttons.forEach((button) => {
            button.addEventListener('click', () => sendRequest(button));
        });
    </script>
</body>
</html>
