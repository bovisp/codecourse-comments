<template>
	<form @submit.prevent="patch">
		<div class="form-group">
			<textarea
				:rows="textareaHeight"
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
			>Edit</button>

			<button 
				class="btn btn-link"
				@click.prevent="cancel"
			>Cancel</button>
		</div>
	</form>
</template>

<script>
	export default {
		props: {
			comment: {
				required: true,
				type: Object
			}
		},

		data () {
			return {
				form: {
					body: this.comment.body
				}
			}
		},

		computed: {
			textareaHeight () {
				return Math.max(
					Math.floor(this.comment.body.split(/\r*\n/).length / 2),
					6
				)
			}
		},

		methods: {
			cancel () {
				window.events.$emit('comment:edit-cancelled', this.comment)
			},

			async patch () {
				let comment = await axios.patch(`/comments/${this.comment.id}`, this.form)

				window.events.$emit('comment:edited', comment.data.data)

				this.cancel()
			}
		}
	}
</script>