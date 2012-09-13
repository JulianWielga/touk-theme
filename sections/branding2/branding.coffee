class window.HeaderView

  $: (selector) ->
    @$el.find(selector)

  constructor: (el) ->
    console.log 'constructor', el
    @$el = el
    @initialize()

  initialize: ->
    console.log 'initialize'
    @$document = jQuery(document)
    @$logo = @$('.logo')
    @$about = @$('.about')
    @$title = @$('.title')
    @$line = @$('.line')
    @$deco = @$('.deco')
    @$background = jQuery('<div class="header-background">').append('<div class="inner">').appendTo @$el
    @$document.on 'scroll.header', @adjustPosition
    @_afterShow()

  adjustPosition: =>
    @_scrollTop = window.pageYOffset
    console.log @_scrollTop


    @$title.css top: if @_scrollTop > @$title._offset.top then 0 else @$title._offset.top - @_scrollTop
    @$line.css top: if @scrollTop > @$line._offset.top then -100 else @$line._offset.top - @_scrollTop

    p = @_scrollTop / @$title._offset.top                   # 0-n
    q = 1 - (@$title.position().top / @$title._offset.top)  # 0-1

    if p < 20
      @$logo.css top: @_calculateTop @$logo._offset.top
      @$about.css top: (@_calculateTop @$about._offset.top) - @_scrollTop
      @$background.css top: @_calculateTop @$background._offset.top
      @$about.css opacity: 1-q

    @oldTitle = @$subtitle.text()
    @lastTitle = ""
    
    @$titles.each (i, el) =>
      $title = jQuery(el)
      if $title.offset().top + $title.height() * (2 / 3) - @_scrollTop < @$background.height()
        @lastTitle = " #{jQuery(el).text()}"
    if @oldTitle isnt @lastTitle
      @$subtitle.stop().hide()
    @$subtitle.text(@lastTitle).fadeIn 150  #'easeInExpo'



  _calculateTop: (offsetTop) ->
    @$title.position().top * offsetTop / @$title._offset.top


  _afterShow: =>
    @$el.parent().height @$el.height()
    @$el.css
      position: 'fixed'
      width: '100%'
      overflow: 'hidden'

    @$title._offset = @$title?.offset()
    @$line._offset = @$line?.offset()
    @$logo._offset = @$logo?.offset()
    @$about._offset = @$about?.offset()
    @$background._offset = @$background?.position()
#    @$background._borderColor = @$background.children().css 'borderColor'
    @$subtitle = @$title.find('.subtitle').hide()
    @$titles = jQuery('#column-main .entry-title')

window.branding2 = new HeaderView(jQuery('#branding2'))
console.log 'branding loaded'