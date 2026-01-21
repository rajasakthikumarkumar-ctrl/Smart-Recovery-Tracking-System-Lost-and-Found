let globalItems = [];
let currentPage = 1;
const itemsPerPage = 12;

// Load items from backend
document.addEventListener('DOMContentLoaded', () => {
  fetch('fetch_items.php')
    .then(r => r.json())
    .then(items => {
      globalItems = items;
      updateStats();
      applyFilters();
      activateControls();
    })
    .catch(e => console.error(e));
});

// Update Lost/Found Stats
function updateStats() {
  const stats = document.getElementById("stats");
  const lost = globalItems.filter(i => i.status === "lost").length;
  const found = globalItems.filter(i => i.status === "found").length;
  stats.innerText = `📌 Lost: ${lost} | ✅ Found: ${found}`;
}

// Apply all filters (search + category + sort)
function applyFilters() {
  const query = document.getElementById("searchBar").value.toLowerCase();
  const category = document.getElementById("categoryFilter").value;
  const sortType = document.getElementById("sortFilter").value;

  let filtered = globalItems.filter(i => {
    return (
      (!category || i.status === category) &&
      (i.item_name.toLowerCase().includes(query) ||
       i.description.toLowerCase().includes(query))
    );
  });

  // Sorting
  filtered.sort((a, b) => {
    return sortType === "newest"
      ? new Date(b.created_at) - new Date(a.created_at)
      : new Date(a.created_at) - new Date(b.created_at);
  });

  renderPage(filtered);
}

// Pagination + Render
function renderPage(items) {
  const feed = document.getElementById("feed");

  if (items.length === 0) {
    feed.innerHTML = "<p style='text-align:center;'>No items found</p>";
    return;
  }

  const start = (currentPage - 1) * itemsPerPage;
  const pageItems = items.slice(start, start + itemsPerPage);

  feed.innerHTML = pageItems
    .map(i => `
      <div class="feed-item">
        <h3>${escapeHtml(i.item_name)} (${i.status.toUpperCase()})</h3>
        <p>${escapeHtml(i.description)}</p>
        ${i.image ? `<img src="${escapeHtml(i.image)}">` : ""}
        <div class="ai">${i.ai_category ? `🧠 AI: ${escapeHtml(i.ai_category)}` : ""}</div>
        <div class="date">Posted on: ${i.created_at}</div>
        <a href="chat_page.html?item_id=${i.id}">Chat about this</a>
      </div>
    `)
    .join("");

  renderPagination(items);
}

// Pagination buttons
function renderPagination(items) {
  const totalPages = Math.ceil(items.length / itemsPerPage);
  const feed = document.getElementById("feed");

  let buttons = `<div style="text-align:center; margin-top:20px;">`;

  if (currentPage > 1) {
    buttons += `<button onclick="changePage(${currentPage - 1})">⬅ Prev</button>`;
  }

  if (currentPage < totalPages) {
    buttons += `<button onclick="changePage(${currentPage + 1})">Next ➡</button>`;
  }

  buttons += `</div>`;
  feed.innerHTML += buttons;
}

function changePage(page) {
  currentPage = page;
  applyFilters();
}

// Attach filter/search listeners
function activateControls() {
  document.getElementById("searchBar").addEventListener("input", applyFilters);
  document.getElementById("categoryFilter").addEventListener("change", applyFilters);
  document.getElementById("sortFilter").addEventListener("change", applyFilters);
}

// Safe HTML
function escapeHtml(s) {
  return s
    ? s.replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
    : "";
}
