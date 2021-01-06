<template>
    <div id="container">
        <h1>Booj Book List!</h1>
        <BookList :bookListId="bookListId"/>
    </div>
</template>

<script>
import BookList from "./BookList";

export default {
    components: {BookList},
    props: ['bookListId']
}
</script>
