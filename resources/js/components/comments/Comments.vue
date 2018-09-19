<template>
	<div>
		<new-comment :endpoint="endpoint" />
	</div>
</template>

<script>
	import NewComment from './NewComment'

	export default {
		props: {
			endpoint: {
				required: true,
				type: String
			}
		},

		components: {
			NewComment
		},

		methods: {
			prependComment (comment) {
				console.log(comment)
			}
		},

		mounted () {
			window.events.$on('comment:stored', this.prependComment)
		}
	}
</script>