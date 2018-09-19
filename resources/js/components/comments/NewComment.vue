<template>
	<div class="mb-5">
		<button 
			class="btn btn-primary btn-block"
			@click.prevent="active = true"
			v-if="!active"
		>Add new comment</button>

		<template v-else>
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
					>Post</button>

					<button 
						class="btn btn-link"
						@click.prevent="active = false"
					>Cancel</button>
				</div>
			</form>
		</template>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				active: false,
				form: {
					body: ''
				}
			}
		},

		props: {
			endpoint: {
				required: true,
				type: String
			}
		},

		methods: {
			async store () {
				let comment = await axios.post(this.endpoint, this.form)

				window.events.$emit('comment:stored', comment.data.data)

				this.active = false

				this.form.body = ''
			}
		}
	}
</script>