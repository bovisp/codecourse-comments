<template>
	<li class="media my-4" :id="`comment-${comment.id}`">
		<img 
		:src="comment.user.avatar" 
			alt="`Avatar for ${comment.user}`"
			class="mr-3" 
		>

		<div class="media-body">
			<p class="mb-2">
				<strong>
					{{ comment.user.name }}
				</strong>

				<small class="text-muted">
					<span v-if="comment.child">
						<strong>replied: </strong>
					</span>

					{{ comment.created_at }}

					<span v-if="comment.edited">
						| edited {{ comment.edited }}
					</span>
				</small>
			</p>

			<template v-if="editing">
				<comment-edit :comment="comment" />
			</template>

			<template v-else>
				<div v-html="body"></div>
			</template>

			

			<ul class="list-inline" v-if="links && user.authenticated && !editing">
				<li class="list-inline-item" v-if="!comment.child">
					<button
						class="btn btn-link"
						@click.prevent="reply"
					>Reply</button>
				</li>

				<li class="list-inline-item" v-if="comment.owner">
					<button
						class="btn btn-link"
						@click.prevent="editing = true"
					>Edit</button>
				</li>
			</ul>

			<template v-if="comment.children">
				<ul class="list-unstyled">
					<comment 
						v-for="child in comment.children"
						:key="child.id"
						:comment="child"
					/>
				</ul>
			</template>
		</div>
	</li>
</template>

<script>
	import Comment from './Comment'
	import CommentEdit from './CommentEdit'
	import marked from 'marked'

	export default {
		name: 'comment',

		props: {
			comment: {
				required: true,
				type: Object
			},

			links: {
				default: true,
				type: Boolean
			}
		},

		components: {
			Comment,
			CommentEdit
		},

		data () {
			return {
				editing: false
			}
		},

		computed: {
			body () {
				return marked(this.comment.body, { sanitize: true })
			}
		},

		methods: {
			reply () {
				window.events.$emit('comment:reply', this.comment)
			}
		},

		mounted () {
			window.events.$on('comment:edit-cancelled', (comment) => {
				if (comment.id === this.comment.id) {
					this.editing = false
				}
			})
		}
	}
</script>