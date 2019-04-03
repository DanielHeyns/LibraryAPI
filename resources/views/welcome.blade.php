<html>
  <Title>Home</Title>
  <head>
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>
    <form>
      Search By ISBN: <input id='isbnSearchField' type='text'>
      <button id='isbnSearch'>Submit</button>
      <br/><br/>
      <button id='showAuthors'>See All Authors</button>
      <button id='showBooks'>See All Books</button>
    </form>

    <h1 id='title'>All Books</h1>

    <div id='authors'></div>
    <div id='books'></div>


    <script>
      function getBookByISBN(isbn) {
        $url = '/api/books/' + isbn.toString();
        $.ajax({
            type: 'GET',
            url: $url,
            success: function(data) {
              data.data = [data.data];
              populateBooks(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              alert('No book with the ISBN: ' + isbn + ' was found');
            },
        });
      };

      function searchByISBN(isbn) {
        $('#showAuthors').show();
        $('#books').show();
        $('#authors').hide();
        $('#showBooks').show();
        document.getElementById('books').innerHTML = '';
        document.getElementById('title').innerHTML = 'ISBN Search Result';

        getBookByISBN(isbn);
      };

      function getAuthors(handleData) {
        $.ajax({
            type: 'GET',
            url: '/api/authors',
            success: function(data) {
              handleData(data);
            },
        });
      };

      function showAuthors() {
        $('#showAuthors').hide();
        $('#books').hide();
        $('#authors').show();
        $('#showBooks').show();
        document.getElementById('authors').innerHTML = '';
        document.getElementById('title').innerHTML = 'All Authors';

        getAuthors(function(output) {
          let data = output.data,
              authorTable = document.createElement('table'),
              headers = document.createElement('tr'),
              name = document.createElement('td'),
              id = document.createElement('td');

          authorTable.border = '2px';

          name.innerHTML = '<b>Author Name</b>';
          id.innerHTML = '<b>ID</b>';

          headers.appendChild(name);
          headers.appendChild(id);
          authorTable.appendChild(headers);

          for (var i = 0; i < data.length; i++) {
            let newAuthor = document.createElement('tr'),
                name = document.createElement('td'),
                id = document.createElement('td');

            name.innerHTML = data[i].name;
            id.innerHTML = data[i].id;

            newAuthor.appendChild(name);
            newAuthor.appendChild(id);
            authorTable.appendChild(newAuthor);
          };

          document.getElementById('authors').appendChild(authorTable);
        });
      };

      function getBooks() {
        $('#showBooks').hide();
        $('#authors').hide();
        $('#books').show();
        $('#showAuthors').show();
        document.getElementById('books').innerHTML = '';
        document.getElementById('title').innerHTML = 'All Books';

        $.ajax({
            type: 'GET',
            url: '/api/books',
            success: function(data) {
              populateBooks(data);
            },
        });
      };


      function populateBooks(output) {
        let data = output.data,
            bookTable = document.createElement('table'),
            headers = document.createElement('tr'),
            name = document.createElement('td'),
            author = document.createElement('td'),
            isbn = document.createElement('td'),
            id = document.createElement('td'),
            pub = document.createElement('td'),
            pubYear = document.createElement('td');

        bookTable.style.width = '100%';
        bookTable.border = '2px';
        headers.align = 'center';

        name.innerHTML = '<b>Title</b>';
        author.innerHTML = '<b>Author</b>';
        isbn.innerHTML = '<b>ISBN</b>';
        id.innerHTML = '<b>ID</b>';
        pub.innerHTML = '<b>Publisher</b>';
        pubYear.innerHTML = '<b>Published Year</b>';

        headers.appendChild(name);
        headers.appendChild(author);
        headers.appendChild(isbn);
        headers.appendChild(id);
        headers.appendChild(pub);
        headers.appendChild(pubYear);

        bookTable.appendChild(headers);

        for (var i = 0; i < data.length; i++) {
          let newBook = document.createElement('tr'),
              name = document.createElement('td'),
              author = document.createElement('td'),
              isbn = document.createElement('td'),
              id = document.createElement('td'),
              pub = document.createElement('td'),
              pubYear = document.createElement('td'),
              image = document.createElement('a');

          newBook.align = 'center';
          name.style.width = '40%';
          author.style.width = '20%';
          isbn.style.width = '10%';
          id.style.width = '5%';
          pub.style.width = '20%';
          pubYear.style.width = '5%';

          image.href = data[i].image_path;
          image.innerHTML = data[i].name;
          author.innerHTML = data[i].author;
          isbn.innerHTML = data[i].ISBN;
          id.innerHTML = data[i].id;
          pub.innerHTML = data[i].pub;
          pubYear.innerHTML = data[i].pub_year;

          name.appendChild(image);
          newBook.appendChild(name);
          newBook.appendChild(author);
          newBook.appendChild(isbn);
          newBook.appendChild(id);
          newBook.appendChild(pub);
          newBook.appendChild(pubYear)

          bookTable.appendChild(newBook);
        };

        document.getElementById('books').appendChild(bookTable);
      };


      $(document).ready(function() {
        //On initial load, show all books
        getBooks();

        $('#isbnSearch').click(function(e) {
          //This prevents the page from reloading on click
          e.preventDefault();
          searchByISBN($('#isbnSearchField').val());
        });

        $('#showAuthors').click(function(e) {
          e.preventDefault();
          showAuthors();
        });

        $('#showBooks').click(function(e) {
          e.preventDefault();
          getBooks();
        });
      });
    </script>
  </body>
</html>
