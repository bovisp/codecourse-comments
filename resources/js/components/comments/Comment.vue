<template>
	<li class="media my-4">
		<img 
		:src="comment.user.avatar" 
			alt="`Avatar for ${comment.user}`"
			class="mr-3" 
		>

		<div class="media-body">
			<p class="mb-2">
				<strong class="mr-2">
					{{ comment.user.name }}
				</strong>

				<small class="text-muted">
					{{ comment.created_at }}
				</small>
			</p>

			<p>
				{{ comment.body }}
			</p>

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
			}
		},

		components: {
			Comment
		}
	}
</script>