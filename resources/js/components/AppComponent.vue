<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form @submit.prevent="processForm">
            <div class="form-group">
                <label for="languages">Select the langauge you want to view meals in</label>
                <select class="form-control" id="languages" v-model="lang">
                    <option v-for="language in languages" :key="language.id" :value="language.code">{{ language.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tags">Select tags you want to filter by</label>
                <select multiple class="form-control" id="tags" v-model="options.tags">
                    <option v-for="tag in tags" :key="tag.id" :value="tag.id">{{ tag.title }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tags">Select category you want to filter by</label>
                <select class="form-control" id="category" v-model="options.category">
                    <option value="">None</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <input class="form-check-input" type="checkbox" id="byDate" v-model="options.searchByDate">
                <label for="byDate">Want to filter by date?</label>
            </div>
            <div class="form-group">
                <label for="date">Select the oldest date you want to options by</label>
                <input class="form-control" type="date" value="" id="date" v-model="options.date">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>
    <br>
    <div class="row">
      <meal-component
        v-for="meal in meals"
        v-bind:key="meal.id"
        v-bind:title="meal.title"
        v-bind:ingredients="meal.ingredients"
        v-bind:category="meal.category"
        v-bind:tags="meal.tags"
      ></meal-component>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      meals: [],
      languages: [],
      tags: [],
      categories: [],
      options: {
          tags: [],
          category: null,
          searchByDate: false,
          date: '',
      },
      lang: "en"
    };
  },
  mounted: function() {
    this.getList('languages');
    this.getList('tags');
    this.getList('categories');
    this.getMeals(this.lang, this.options);
  },
  methods: {
    getMeals(language, options) {
        var filter = {};
        if(options.category) {
            filter.category = options.category;
        }
        if(options.tags.length > 0) {
            filter.tags = options.tags.join(',');
        }
        if(options.searchByDate) {
            filter.diff_time = Math.floor(new Date(options.date).getTime() / 1000);
        }
        var queryString = qs.stringify({
            lang: language,
            with: "ingredients,tags,category",
            ...filter
        });
        axios.get("/api/meals?" + queryString).then(res => {
            this.meals = res.data.data;
        });
    },
    getList(type) {
        axios.get('/api/' + type).then(res => {
            this[type] = res.data.data;
        });
    },
    processForm() {
        this.getMeals(this.lang, this.options);
    }
  } 
};
</script>
