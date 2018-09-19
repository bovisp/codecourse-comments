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