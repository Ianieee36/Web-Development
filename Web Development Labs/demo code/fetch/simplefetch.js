// modern simpleajax.js
// Replaces old XHR-based code with async/await + fetch + AbortController.

const form = document.getElementById('login-form');
const output = document.getElementById('output');
const statusEl = document.getElementById('status');
const submitBtn = document.getElementById('submitBtn');

// Helper: formats errors nicely
function showError(err) {
  statusEl.textContent = '';
  output.innerHTML = `<p class="error"><strong>Error:</strong> ${err.message || err}</p>`;
}

// Core fetch helper with timeout and JSON/text handling
async function getData(dataSource, { name, pwd }, { timeoutMs = 8000 } = {}) {
  const ac = new AbortController();
  const id = setTimeout(() => ac.abort(), timeoutMs);

  try {
    // Prefer POST for credentials; fallback to GET if you must mimic the old querystring behaviour
    const url = new URL(dataSource, window.location.href);

    const resp = await fetch(url.toString(), {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, pwd }),
      signal: ac.signal, // Watch this signal. If the controller aborts, stop what you're doing.
      // Include credentials if your endpoint needs cookies/session:
      // credentials: 'include',
    });

    // Handle HTTP-level errors
    if (!resp.ok) {
      const text = await resp.text().catch(() => '');
      throw new Error(`HTTP ${resp.status} ${resp.statusText}${text ? ` — ${text}` : ''}`);
    }

    // Try JSON first, fallback to text
    const contentType = resp.headers.get('content-type') || '';
    if (contentType.includes('application/json')) {
      return await resp.json();
    }
    return await resp.text();
  } finally {
    clearTimeout(id);
  }
}

form?.addEventListener('submit', async (e) => {
  e.preventDefault(); //supersede default action
  const name = /** @type {HTMLInputElement} */(document.getElementById('name')).value.trim();
  const pwd = /** @type {HTMLInputElement} */(document.getElementById('pwd')).value;

  if (!name || !pwd) {
    showError(new Error('Please enter both user name and password.'));
    return;
  }

  output.textContent = '';
  statusEl.textContent = 'Loading…';
  submitBtn.disabled = true;

  try {
    const data = await getData('data.php', { name, pwd }); // <-- change endpoint to your API

    if (typeof data === 'string') {
      // Plain text response
      output.innerHTML = `<pre>${data}</pre>`;
    } else {
      // JSON response
      output.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
    }
    statusEl.textContent = 'Done';
  } catch (err) {
    if (err?.name === 'AbortError') {
      showError(new Error('Request timed out.'));
    } else {
      showError(err);
    }
  } finally {
    submitBtn.disabled = false;
  }
});

// Optional: expose a small API that mirrors the old signature if you need drop-in replacement
// Old: getData(dataSource, divID, aName, aPwd)
/*
window.getData = async function legacyGetData(dataSource, divID, aName, aPwd) {
  const place = document.getElementById(divID);
  if (!place) return;
  try {
    const result = await getData(dataSource, { name: aName, pwd: aPwd });
    place.innerHTML = typeof result === 'string' ? result : `<pre>${JSON.stringify(result, null, 2)}</pre>`;
  } catch (err) {
    place.innerHTML = `<p class="error"><strong>Error:</strong> ${(err && err.message) || err}</p>`;
  }
};
*/