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
    @$document = jQuery(document)
    @$logo = @$('.logo')
    @$about = @$('.about')
    @$title = @$('.title')
    @$line = @$('.line')
    @$deco = @$('.deco')
    @$background = jQuery('<div class="header-background">').append('<div class="inner">').appendTo @$el
    @$document.on 'scroll.header touchstop.header', @adjustPosition
    @_afterShow()

  adjustPosition: =>
    @_scrollTop = window.pageYOffset
    @_parentTop = @$background.offsetParent().offset().top

    @$title.css top: if @_scrollTop > @$title._top then 0 else @$title._top - @_scrollTop
    @$line.css top: if @_scrollTop > @$line._top then -100 else @$line._top - @_scrollTop


    p = @_scrollTop / @$title._top                   # 0-n
    if p < 20
      q = 1 - (@$title.position().top / @$title._top)  # 0-1
      @$logo.css top: @_calculateTop @$logo._top
      @$about.css top: (@_calculateTop @$about._top) - @_scrollTop
      @$background.css top: @_calculateTop @$background._top
      @$about.css opacity: 1-q

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


  _afterShow: =>
    _scrollTop = window.pageYOffset
    _parentTop = @$background.offsetParent().offset().top
    @_positionDiff = _parentTop - _scrollTop

    @$title._top = @$title?.offset().top - @_positionDiff
    @$line._top = @$line?.offset().top - @_positionDiff
    @$logo._top = @$logo?.offset().top - @_positionDiff
    @$about._top = @$about?.offset().top - @_positionDiff
    @$background._top = @$background?.offset().top - @_positionDiff
#    @$background._borderColor = @$background.children().css 'borderColor'
    @$subtitle = @$title.find('.subtitle').hide()
    @$titles = jQuery('#column-main .entry-title')

    @$el.css
      position: 'fixed'
      width: '100%'


window.branding2 = new HeaderView(jQuery('#branding2'))