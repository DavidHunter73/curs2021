<template>
  <html lang="es">
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Liber</title>
    </head>

    <body>
      <h1>PÁGINA PRINCIPAL FUNCIONA?</h1>
      <div>AQUI VA EL CARRUSEL</div>

      <form @submit.prevent="SearchBooks">
        <input
          type="text"
          v-model="preSearch"
          name="search"
          placeholder="Busca un libro"
        />
        <button type="submit" id="search_button">Buscar</button>
      </form>

      <div id="books_searched">
        <div v-for="b in booksFilter" :key="b.isbn" id="book_container">
          <h3 @click="BookInformation(b.isbn)">Titulo: {{ b.title }}</h3>
          <p @click="BookInformation(b.isbn)">Autor: {{ b.author }}</p>
          <img
            v-bind:src="'../storage/app/' + b.cover"
            @click="BookInformation(b.isbn)"
          />
          <star-rating
            v-model="b.rating"
            v-bind:rating="b.rating"
            v-bind:read-only="true"
            v-bind:show-rating="false"
          ></star-rating>
        </div>
      </div>
    </body>
  </html>
</template>

<script>
import StarRating from "vue-star-rating";

export default {
  data() {
    return {
      preSearch: "",
      postSearch: "",
      books: [],
    };
  },
  computed: {
    booksFilter: function () {
      let search = this.postSearch.toLowerCase();

      return this.books.filter(
        (b) =>
          b.title.toLowerCase().includes(search) ||
          b.author.toLowerCase().includes(search)
      );
    },
  },
  mounted() {
    axios.get("api/books").then((response) => {
      this.books = response.data;
    });
  },
  methods: {
    SearchBooks() {
      this.postSearch = this.preSearch;
    },
    BookInformation(isbn) {
      this.$router.push("book?isbn=" + isbn);
    },
  },
};
</script>

<style>
body {
  padding: 0;
  margin: 0;
}

#book_container {
  background-color: aqua;
}
</style>