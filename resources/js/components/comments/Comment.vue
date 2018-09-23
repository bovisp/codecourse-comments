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
				</small>
			</p>

			<p>
				{{ comment.body }}
			</p>

			<ul class="list-inline" v-if="links && user.authenticated">
				<li class="list-inline-item" v-if="!comment.child">
					<button
						class="btn btn-link"
						@click.prevent="reply"
					>Reply</button>
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
			Comment
		},

		methods: {
			reply () {
				window.events.$emit('comment:reply', this.comment)
			}
		}
	}
</script>