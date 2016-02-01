function check()
{
	
}

var UsePenName;
var UseComment;

function CallComment(UseArticleId)
{
	var items = [];
	
	$.getJSON("/geoapp/Article/Comment.json", function(data){
			
			$.each(data.CommentJSON, function(key,value) {
								
				var ArticleId = value.Comment.article_id;
				var PenName = value.Comment.pen_name;
				var Comment = value.Comment.comment;
				
				if(UseArticleId == ArticleId)
				{
					UsePenName = PenName;
					UseComment = Comment;
				
				
				  items.push(
				"<div class='row'><div class='col-md-2'><img class='img-responsive' src='/geoapp/img/"+UsePenName+"_display.jpg'></div><div class='col-md-9'><h3 class='text-primary'>"+UsePenName+"</h3><h4>"+UseComment+"</h4></div></div><br/>"
				  );
				}  
				
			});//end each function
			
			 $("#get_comment").html( items.join(""));
			 
	});//end getJSON function	
}
