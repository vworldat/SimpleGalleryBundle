SimpleSimpleGalleryBundle
===================

Simple drop-in propel / admingenerator galleries for Symfony2

*THIS IS WORK IN PROGRESS! USE AT YOUR OWN RISK!*


## Quickdocs

- install
- add to appkernel
- enable admingenerator


fixtures.yml:
```
C33s\SimpleGalleryBundle\Model\Gallery:
    background:
        title:                      Background
        slug:                       background
        is_listed:                  false
        ImagesLoadFromDirectory:    app/propel/attachments/Gallery/background
        ImageFilePath:              app/propel/attachments/Gallery/background/gallery-avatar.jpg
```

twig:

simple example
```
<ul>
{% for item in single_gallery('GallerySlug').galleryItems %}
	<li><img src="{{ item.image|att_url('liip_imagine_filter_name') }}"></li>
{% endfor %}
</ul>
```

example with vegas slider:
```
$(function() {
    $.vegas('slideshow', {
  delay: 5000,
  backgrounds: [{% spaceless %}
   {% for item in single_gallery('background').galleryItems %}
    { src: '{{ item.image|att_url('header') }}', fade: 1000 }{% if not loop.last %},{% endif %}
   {% endfor %}
  {% endspaceless %}]
    })('overlay', {
     src: '{% image 'media/components/vegas/dist/overlays/06.png' %}{{ asset_url }}{% endimage %}'
 });
});
```

