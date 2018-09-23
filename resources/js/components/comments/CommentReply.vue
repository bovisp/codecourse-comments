<template>
	<div>
		<comment :comment="comment" :links="false" />

		<form @submit.prevent="store" id="reply">
			<div class="form-group">
				<label for="body">Comment</label>

				<textarea
					id="body"
					rows="10"
					class="form-control"
					autofocus="autofocus"
					v-model="form.body"
				></textarea>

				<p class="form-text text-muted">
					Markdown and code highlighting are supported
				</p>
			</div>

			<div class="form-group">
				<button 
					class="btn btn-primary" 
					type="submit"
				>Reply</button>

				<button 
					class="btn btn-link"
					@click.prevent="cancel"
				>Cancel</button>
			</div>
		</form>
	</div>
</template>

<script>
	import Comment from './Comment'
	import VueScrollTo from 'vue-scrollto'

	export default {
		props: {
			comment: {
				required: true,
				type: Object
			}
		},

		components: {
			Comment
		},

		data () {
			return {
				form: {
					body: ''
				}
			}
		},

		methods: {
			async store () {
				let reply = await axios.post(`/comments/${this.comment.id}/replies`, this.form)

				window.events.$emit('comment:replied', {
					comment: this.comment,
					reply: reply.data.data
				})

				this.cancel()
			},

			cancel () {
				window.events.$emit('comment:reply-cancelled')
			}
		},

		mounted () {
			VueScrollTo.scrollTo('#reply', 500)
		}
	}
</script>