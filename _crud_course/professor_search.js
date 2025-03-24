// search.js
function searchProfessors() {
  const searchInput = document.getElementById('professor_search').value.trim();

  if (searchInput !== '') {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'professor_search.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        const searchResultsContainer = document.getElementById('search_results_container');
        searchResultsContainer.innerHTML = this.responseText;
      }
    };

    xhr.send('search=' + encodeURIComponent(searchInput));
  } else {
    // Clear the search results container if the search input is empty
    const searchResultsContainer = document.getElementById('search_results_container');
    searchResultsContainer.innerHTML = '';
  }
}