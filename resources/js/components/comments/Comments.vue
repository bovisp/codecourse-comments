<template>
	<div>
		<template v-if="reply">
			<comment-reply :comment="reply" />
		</template>

		<template v-else>
			<h3 class="mb-5">{{ meta.total }} comments</h3>

			<new-comment 
				:endpoint="endpoint" 
				v-if="user.authenticated"
			/>

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
		</template>
	</div>
</template>

<script>
	import NewComment from './NewComment'
	import CommentReply from './CommentReply'
	import Comment from './Comment'
	import VueScrollTo from 'vue-scrollto'

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
				meta: {},
				reply: null
			}
		},

		components: {
			NewComment,
			Comment,
			CommentReply
		},

		methods: {
			async fetch (page = 1) {
				let response = await axios.get(`${this.endpoint}?page=${page}`)

				this.comments = response.data.data
				this.meta = response.data.meta
			},

			async fetchMeta () {
				let response = await axios.get(`${this.endpoint}?page=${this.meta.current_page}`)

				this.meta = response.data.meta
			},

			async more () {
				let response = await axios.get(`${this.endpoint}?page=${this.meta.current_page + 1}`)

				this.comments.push(...response.data.data)
				this.meta = response.data.meta
			},

			async prepend (comment) {
				this.comments.unshift(comment)

				await this.fetchMeta()

				if (this.meta.current_page < this.meta.last_page) {
					this.comments.pop();
				}
			},

			append (comment, reply) {				
				let commentToAppend = _.find(this.comments, { 'id': comment.id })

				if (!commentToAppend.children) {
					commentToAppend.children = []
				}

				commentToAppend.children.push(reply)
			},

			setReplying (comment) {
				this.reply = comment
			},

			scrollToComment (reply) {
				setTimeout(() => VueScrollTo.scrollTo(`#comment-${reply.id}`, 500), 200)
			},

			editComment (comment) {
				if (comment.child) {
					_.assign(
						_.find(
							this.comments, { id: comment.parent_id }
						)
						.children
						.find(child => child.id == comment.id),
						comment
					)

					return
				}

				_.assign(_.find(this.comments, { id: comment.id }), comment)
			},

			deleteComment (comment) {
				if (comment.child) {
					let parentComment = _.find(this.comments, { id: comment.parent_id })

					parentComment.children = parentComment.children.filter(child => {
						return child.id !== comment.id
					})

					return
				}

				this.comments = this.comments.filter(comnt => comnt.id !== comment.id)

				this.meta.total--
			}
		},

		mounted () {
			this.fetch(1)

			window.events.$on('comment:stored', this.prepend)

			window.events.$on('comment:reply', this.setReplying)

			window.events.$on('comment:reply-cancelled', () => this.reply = null)

			window.events.$on('comment:replied', ({ comment, reply}) => {
				this.append(comment, reply)

				this.scrollToComment(reply)
			})

			window.events.$on('comment:edited', this.editComment)

			window.events.$on('comment:deleted', this.deleteComment)
		}
	}
</script>