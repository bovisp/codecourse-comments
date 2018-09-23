<template>
	<form @submit.prevent="patch">
		<div class="form-group">
			<textarea
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

		methods: {
			cancel () {
				window.events.$emit('comment:edit-cancelled', this.comment)
			},

			patch () {
				console.log(this.form)
			}
		}
	}
</script>