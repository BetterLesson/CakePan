#CakePan 

CakePan is a CakePHP view helper that renders Mustache templates.

It will load and render sub-templates as well

## Use

### install
First - make afolder called 'mustache' in your app/vendors folder. Add the Mustache PHP library to your app/vendor folder. from https://github.com/bobthecow/mustache.php/

Then, place this helper out into the app/views/helpers folder of your CakePHP project. 

### production
Write your elements in mustache format with the extension ".mustache" rather than ".ctp"!

The Mustache manual is here: http://mustache.github.com/

In your view - render an element using $this->Mustache->render('element'); just like you would render a CakePHP element. Make sure all the variables you need are set in the controller.

Sub-templates should follow the same naming convention. Mustache will pass the variables to the sub-template in the context that it's called. For example, a nested template for a blog post with comments might look like:

/views/elements/posts/post.mustache :
{{#Post}}
  <h2>{{title}}</h2>
  <div>
    {{text}}
  </div>
{{/Post}}
{{#Comment}}
  {{>post/comment}}
{{/Comment}}

/views/elements/posts/comment.mustache :
<div>
<h3>{{#User}}{{name}}{{/User}} said: </h3>
<p>{{text}}</p>
</div>

In this example, the post/comment element is called within the context of one of the comments (which in this case belongs to a User)