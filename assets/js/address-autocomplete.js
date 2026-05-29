(function () {
  "use strict";

  const input = document.getElementById("address");

  if (!input) {
    return;
  }

  const csvPath = "assets/data/cape_location.csv";
  const maxSuggestions = 10;
  let locations = [];

  const suggestionsBox = document.createElement("div");
  suggestionsBox.className = "address-suggestions";
  suggestionsBox.setAttribute("role", "listbox");
  suggestionsBox.hidden = true;

  const wrapper = document.createElement("div");
  wrapper.className = "address-autocomplete-wrap";
  input.insertAdjacentElement("beforebegin", wrapper);
  wrapper.appendChild(input);
  wrapper.appendChild(suggestionsBox);

  input.setAttribute("autocomplete", "off");
  input.setAttribute("aria-autocomplete", "list");
  input.setAttribute("aria-expanded", "false");

  function parseCsvRows(csvText) {
    const rows = [];
    let row = [];
    let value = "";
    let inQuotes = false;

    for (let i = 0; i < csvText.length; i += 1) {
      const char = csvText[i];
      const nextChar = csvText[i + 1];

      if (char === '"' && inQuotes && nextChar === '"') {
        value += '"';
        i += 1;
        continue;
      }

      if (char === '"') {
        inQuotes = !inQuotes;
        continue;
      }

      if (char === "," && !inQuotes) {
        row.push(value.trim());
        value = "";
        continue;
      }

      if ((char === "\n" || char === "\r") && !inQuotes) {
        if (char === "\r" && nextChar === "\n") {
          i += 1;
        }

        row.push(value.trim());
        if (row.some(Boolean)) {
          rows.push(row);
        }

        row = [];
        value = "";
        continue;
      }

      value += char;
    }

    row.push(value.trim());
    if (row.some(Boolean)) {
      rows.push(row);
    }

    return rows;
  }

  function getLocationsFromCsv(csvText) {
    const rows = parseCsvRows(csvText);
    const headers = rows.shift() || [];
    const locationIndex = headers.findIndex(function (header) {
      return header.toLowerCase() === "location";
    });

    if (locationIndex === -1) {
      return [];
    }

    return rows
      .map(function (row) {
        return row[locationIndex] || "";
      })
      .filter(Boolean);
  }

  function hideSuggestions() {
    suggestionsBox.hidden = true;
    suggestionsBox.innerHTML = "";
    input.setAttribute("aria-expanded", "false");
  }

  function showSuggestions(matches) {
    suggestionsBox.innerHTML = "";

    matches.forEach(function (location) {
      const option = document.createElement("button");
      option.type = "button";
      option.className = "address-suggestion-item";
      option.textContent = location;
      option.setAttribute("role", "option");

      option.addEventListener("click", function () {
        input.value = location;
        hideSuggestions();
        input.focus();
      });

      suggestionsBox.appendChild(option);
    });

    suggestionsBox.hidden = matches.length === 0;
    input.setAttribute("aria-expanded", matches.length > 0 ? "true" : "false");
  }

  function updateSuggestions() {
    const query = input.value.trim().toLowerCase();

    if (!query) {
      hideSuggestions();
      return;
    }

    const matches = locations
      .filter(function (location) {
        return location.toLowerCase().includes(query);
      })
      .slice(0, maxSuggestions);

    showSuggestions(matches);
  }

  fetch(csvPath)
    .then(function (response) {
      if (!response.ok) {
        throw new Error("Could not load address data.");
      }

      return response.text();
    })
    .then(function (csvText) {
      locations = getLocationsFromCsv(csvText);
    })
    .catch(function () {
      locations = [];
      hideSuggestions();
    });

  input.addEventListener("input", updateSuggestions);

  document.addEventListener("click", function (event) {
    if (event.target !== input && !suggestionsBox.contains(event.target)) {
      hideSuggestions();
    }
  });
})();
