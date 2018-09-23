<template>
	<div>
		<comment :comment="comment" :links="false" />

		<form @submit.prevent="store">
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
			store () {
				console.log(this.form)
			},

			cancel () {
				window.events.$emit('comment:reply-cancelled')
			}
		}
	}
</script>