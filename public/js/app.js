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
		this.errorMessage = '';
		this.searchInputClass = 'form-control';
		this.defaultSearchInputClass = 'form-control';
		this.shows = '';
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
		axios.get('/api/?q=' + this.searchPhrase)
			.then(this.onSuccess.bind(this))
		 	.catch(this.onFail.bind(this));
	}

	onSuccess(response) {
		this.shows = response.data.results.map(function(show) {
			let imgSrc = show.image !== null ? show.image.medium : '/img/no-img-portrait-text.png';
			return {
				title: show.name,
				img: imgSrc
			};
		});
	}

	onFail(error) {
		if (error.response === undefined) {
			this.errorMessage = 'Something went wrong. Please try again later';
		} else {
			this.errorMessage = error.response.data.q[0].replace(/The q/, 'This');
		}
		this.searchInputClass += ' is-invalid';
	}
}


new Vue({
	el: '#app-container',

	data: {
		form: new Form({
			searchPhrase: ''
		}),
	},

	methods: {
		onSubmit() {
			this.form.submit();
		},
	},
});