isIOS = /iphone|ipad|ipod|/i.test(navigator.userAgent.toLowerCase())
isAndroid = /android/i.test(navigator.userAgent.toLowerCase())
isWindowsMobile = /windows\sce|windows\smobile/i.test(navigator.userAgent.toLowerCase())
isOtherMobile = /blackberry|mini|palm/i.test(navigator.userAgent.toLowerCase())
isMobile = isOtherMobile or isWindowsMobile or isAndroid

class window.HeaderView

	$el: null
	$document: null
	$logo: null
	$about: null
	$title: null
	$titles: null
	$line: null
	$deco: null
	$background: null

	oldTitle: ''
	lastTitle: ''

	_scrollTop: 0
	_parentTop: 0
	_positionDiff: 0

	$: (selector) ->
		@$el.find(selector)

	constructor: (el) ->
		@$el = el
		@initialize()

	initialize: ->
		@$window = jQuery(window)
		@$document = jQuery(document)
		@$logo = @$('.logo')
		@$about = @$('.about')
		@$title = @$('.title')
		@$line = @$('.line')
		@$deco = @$('.deco')
		@$background = jQuery('<div class="header-background">').append('<div class="inner">').appendTo @$el
		@$window.on 'scroll.header touchstop.header', @_adjustPosition
		@$document.on 'ready.header', =>
			@_savePositions()
			@_afterShow()

	_adjustPosition: =>
		return if isMobile

		@_scrollTop = @$document.scrollTop()
		@_parentTop = @$background.offsetParent().offset().top

		@$title.css top: if @_scrollTop > @$title._top then 0 else @$title._top - @_scrollTop
		@$line.css top: if @_scrollTop > @$line._top then -100 else @$line._top - @_scrollTop


		# 0 <= p < n
		p = @_scrollTop / @$title._top
		if p < 20
			# 0 <= q <= 1
			q = 1 - (@$title.position().top / @$title._top)
			@$about.css opacity: 1 - q

		@$logo.css top: @_calculateTop @$logo._top
		@$about.css top: (@_calculateTop @$about._top) - @_scrollTop
		@$background.css top: @_calculateTop @$background._top

		@oldTitle = @$subtitle.text()
		@lastTitle = ""

		@$titles.each (i, el) =>
			$title = jQuery(el)
			if $title.offset().top + ($title.height() / 4) < @_scrollTop + @$background.height() + @_positionDiff
				@lastTitle = jQuery(el).text()

		if @oldTitle isnt @lastTitle
			@$subtitle.stop().hide()
		@$subtitle.text(@lastTitle).fadeIn 250, 'easeInExpo'



	_calculateTop: (offsetTop) ->
		@$title.position().top * offsetTop / @$title._top


	_savePositions: =>
		_scrollTop = @$document.scrollTop()
		_parentTop = @$background.offsetParent().offset().top
		@_positionDiff = _parentTop - _scrollTop

		@$title._top = parseInt @$title?.css('top')
		@$line._top = parseInt @$line?.css('top')
		@$logo._top = parseInt @$logo?.css('top')
		@$about._top = parseInt @$about?.css('top')
		@$background._top = -(@$background?.height() + 10) - @_positionDiff
		@$background.css top: @$background._top
	#    @$background._borderColor = @$background.children().css 'borderColor'

	_afterShow: =>
		@$subtitle = @$title.find('.subtitle').hide()
		@$titles = jQuery('#column-main .entry-title')
		top = @_positionDiff
		@$el.css
			position: if isMobile then 'absolute' else 'fixed'
			width: '100%'
			top: top


window.branding2 = new HeaderView(jQuery('#branding2'))

