<template>
    <li>
        <strong>{{ title }}</strong>
        by {{ author }}
        <button class="delete" @click="$emit('delete-book')">x</button>
    </li>
</template>

<script>
export default {
    props: ['author', 'title']
}
</script>
