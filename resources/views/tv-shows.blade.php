@extends('layouts.app')

@section('page')
    <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">TV shows</h1>

    <hr class="mt-2 mb-5">

    <div class="mb-5">
        <form method="get" action="/" @submit.prevent="onSubmit">
            <div class="input-group mb-3">
                <div id="search-phrase-label" class="input-group-prepend">
                    <span class="input-group-text">TV show</span>
                </div>
                <input type="text"
                       name="search_phrase"
                       :class="form.searchInputClass"
                       placeholder="Enter a TV show name"
                       aria-describedby="search-phrase-label"
                       v-model="form.searchPhrase"
                       @change="form.clearError()"
                />
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" :disabled="form.hasError()">Search</button>
                </div>
                <div id="search-error" class="invalid-feedback" v-text="form.errorMessage"></div>
            </div>
        </form>
    </div>

    <search-results id="search-results-container" :shows="this.form.shows"></search-results>

@endsection