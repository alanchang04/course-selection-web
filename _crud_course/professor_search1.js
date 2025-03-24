function searchProfessors1() {
    const searchInput = document.getElementById('professor_search1').value.trim();
  
    if (searchInput !== '') {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'search_professors.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
      xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          const searchResultsContainer = document.getElementById('search_results_container1');
          searchResultsContainer.innerHTML = this.responseText;
        }
      };
  
      xhr.send('search=' + encodeURIComponent(searchInput));
    } else {
      // Clear the search results container if the search input is empty
      const searchResultsContainer = document.getElementById('search_results_container1');
      searchResultsContainer.innerHTML = '';
    }
  }