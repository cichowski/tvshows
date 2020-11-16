Vue.component('search-results', {

	props: ['shows'],

	template: `
		<div class="row text-center">
			<div class="col-lg-3 col-md-4 col-6 tv-item" v-for="show in shows">
				<div class="thumbnail">
					<div class="image-wrapper">
						<img class="img-fluid img-thumbnail" :src="show.img" :title="show.title">
					</div>
					<div class="caption">
						<h3 class="title">{{ show.title }}</h3>
					</div>
				</div>
			</div>
        </div>
	`
});


class Form {
	constructor(data) {
		this.searchPhrase = data.searchPhrase;
		this.page = data.page;
		this.defaultSearchInputClass = 'form-control';
		this.searchInputClass = this.defaultSearchInputClass ;
		this.shows = [];
		this.errorMessage = '';
	}

	clearError() {
		this.errorMessage = '',
		this.searchInputClass = this.defaultSearchInputClass;
	}

	hasError() {
		return this.errorMessage.length > 0;
	}

	reset() {
		this.q = '';
		this.errorMessage = '';
	}

	submit() {
		axios.get('/api/?p=1&q=' + this.searchPhrase)
			.then(this.onSuccess.bind(this))
		 	.catch(this.onFail.bind(this));
	}

	loadNextPage() {
		if (this.lastPage === this.page) {
			return;
		}

		this.page++;
		axios.get('/api/?p=' + this.page + '&q=' + this.searchPhrase)
			.then(this.onPageLoad.bind(this));
	}

	onSuccess(response) {
		this.shows = this.retrieveDataFromResponse(response.data.results);
		this.lastPage = response.data.no_pages;
		this.page = 1;
	}

	onPageLoad(response) {
		this.shows = this.shows.concat(this.retrieveDataFromResponse(response.data.results));
		this.lastPage = response.data.no_pages;
	}

	onFail(error) {
		if (error.response === undefined) {
			this.errorMessage = 'Something went wrong. Please try again later';
		} else {
			this.errorMessage = error.response.data.q[0].replace(/The q/, 'This');
		}
		this.searchInputClass += ' is-invalid';
	}

	retrieveDataFromResponse(results) {
		return results.map(function(show) {
			let imgSrc = show.image !== null ? show.image.medium : '/img/no-img-portrait-text.png';
			return {
				title: show.name,
				img: imgSrc
			};
		});
	}
}


new Vue({
	el: '#app-container',

	data: {
		form: new Form({
			searchPhrase: '',
			page: 1
		}),
	},

	methods: {
		onSubmit() {
			this.form.submit();
		},

		loadMoreResults() {
			if (this.shouldLoadMoreResults()) {
				this.form.loadNextPage();
			}
		},

		shouldLoadMoreResults() {
			let resultsContainer = document.getElementById('search-results-container');
			let heightOfResultsContainer = resultsContainer.offsetHeight;
			let distanceFromTop = resultsContainer.offsetTop;

			return (
				window.pageYOffset >= (distanceFromTop + heightOfResultsContainer) * 0.60
			);
		}
	},

	mounted() {
		window.addEventListener('scroll', this.loadMoreResults);
	}
});