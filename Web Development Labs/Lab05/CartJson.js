// Renders the current cart state into the #cart element
function handleResponse(data) {
  const cartEl = document.getElementById("cart");
  cartEl.innerHTML = "";

  if (data && Object.keys(data).length > 0) {
    for (const key in data) {
      const line = document.createElement("span");

      const text = document.createTextNode(key + " (" + data[key] + ") ");
      const removeLink = document.createElement("a");
      removeLink.href = "#";
      removeLink.textContent = "Remove";
      removeLink.addEventListener("click", (e) => {
        e.preventDefault();
        AddRemoveItem("Remove", key);
      });

      line.appendChild(text);
      line.appendChild(removeLink);
      cartEl.appendChild(line);
      cartEl.appendChild(document.createElement("br"));
    }
  } else {
    cartEl.textContent = "Cart is empty";
  }
}

// Sends an Add or Remove action to test.php
function AddRemoveItem(action, bookName = "") {
  const url =
    "test.php?action=" +
    encodeURIComponent(action) +
    "&book=" +
    encodeURIComponent(bookName) +
    "&value=" +
    new Date().getTime();

  fetch(url)
    .then((response) => response.json())
    .then((data) => handleResponse(data))
    .catch((error) => console.error("Error:", error));
}

// Fetches all books from getBooks.php and renders them into #book-list
function loadBooks() {
  const listDiv = document.getElementById("book-list");
  listDiv.textContent = "Loading...";

  fetch("getBooks.php")
    .then((response) => response.json())
    .then((data) => {
      listDiv.innerHTML = "";

      if (!data || data.length === 0) {
        listDiv.textContent = "No books available.";
        return;
      }

      data.forEach((book) => {
        const div = document.createElement("div");
        div.className = "book-item";

        // Cover image
        const img = document.createElement("img");
        img.src = book.cover || "";
        img.width = 100;
        img.alt = book.title || "Book cover";

        // Details
        const details = document.createElement("p");
        details.innerHTML =
          "<strong>Title:</strong> " + sanitise(book.title) + "<br>" +
          "<strong>Authors:</strong> " + sanitise(book.authors) + "<br>" +
          "<strong>ISBN:</strong> " + sanitise(book.isbn) + "<br>" +
          "<strong>Price:</strong> $" + sanitise(String(book.price));

        // Add to cart link
        const addLink = document.createElement("a");
        addLink.href = "#";
        addLink.textContent = "Add to Cart";
        addLink.addEventListener("click", (e) => {
          e.preventDefault();
          AddRemoveItem("Add", book.title);
        });

        div.appendChild(img);
        div.appendChild(details);
        div.appendChild(addLink);
        listDiv.appendChild(div);
      });
    })
    .catch((error) => {
      listDiv.textContent = "Failed to load books. Please try again.";
      console.error("Error fetching books:", error);
    });
}

// Escapes any HTML characters to prevent XSS
function sanitise(str) {
  const div = document.createElement("div");
  div.textContent = str || "";
  return div.innerHTML;
}

loadBooks();