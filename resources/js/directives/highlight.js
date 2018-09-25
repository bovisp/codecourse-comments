import hljs from 'highlight.js'

export default {
	deep: true,

	bind: (el, binding) => {
		let targets = el.querySelectorAll('code')

		_.forEach(targets, target => {
			hljs.highlightBlock(target)
		})
	}
}