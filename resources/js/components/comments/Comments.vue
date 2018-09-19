<template>
	<div>
		<h3 class="mb-5">{{ meta.total }} comments</h3>

		<new-comment :endpoint="endpoint" />

		<template v-if="comments.length">
			<ul class="list-unstyled">
				<comment 
					v-for="comment in comments"
					:key="comment.id"
					:comment="comment"
				/>
			</ul>
		</template>

		<div 
			class="alert alert-primary" 
			role="alert"
			v-else
		>No comments to display</div>

		<button 
			class="btn btn-light btn-block"
			@click.prevent="more"
			v-if="meta.current_page < meta.last_page"
		>Show more</button>
	</div>
</template>

<script>
	import NewComment from './NewComment'
	import Comment from './Comment'

	export default {
		props: {
			endpoint: {
				required: true,
				type: String
			}
		},

		data () {
			return {
				comments: [],
				meta: {}
			}
		},

		components: {
			NewComment,
			Comment
		},

		methods: {
			async fetch (page = 1) {
				let response = await axios.get(`${this.endpoint}?page=${page}`)

				this.comments = response.data.data
				this.meta = response.data.meta
			},

			async more () {
				let response = await axios.get(`${this.endpoint}?page=${this.meta.current_page + 1}`)

				this.comments.push(...response.data.data)
				this.meta = response.data.meta
			},

			prepend (comment) {
				console.log(comment)
			}
		},

		mounted () {
			this.fetch(1)

			window.events.$on('comment:stored', this.prepend)
		}
	}
</script>