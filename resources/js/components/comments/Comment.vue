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
		</div>
	</li>
</template>

<script>
	export default {
		props: {
			comment: {
				required: true,
				type: Object
			}
		}
	}
</script>