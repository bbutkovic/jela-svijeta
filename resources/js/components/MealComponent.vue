<template>
    <div class="card col-md-5">
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ category ? category.title : 'No category' }}</h6>
            <p class="card-text">
                Ingredients: {{ ingredients.map(i => i.title).join(', ') }}
                <br>
                Tags: {{ tags.map(i => i.title).join(', ') }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'ingredients', 'category', 'tags']
    }
</script>
