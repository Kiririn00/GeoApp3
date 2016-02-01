//--------------------- This is for add file feild ------------------------------//
$(document).ready(function() {

var FieldImageCount=1; //to keep track of text box added	
	
var MaxInputs       = 8; //maximum input boxes allowed
var InputsWrapper   = $("#PasteImageField."+FieldImageCount+""); //Input boxes wrapper ID
var AddImageField       = $("#AddImageField."+FieldImageCount+""); //Add button ID
console.log(FieldImageCount);
var x = InputsWrapper.length; //initlal text box count

$(AddImageField).click(function (e)  //on add input button click
{
        if(x <= MaxInputs) //max input box allowed
        {
            FieldImageCount++; //text box added increment
            //add input box
            $(InputsWrapper).append('<div><input type="file" name="field_'+FieldImageCount+'" id="field_'+ FieldImageCount +'" value="Text '+ FieldImageCount +'" required /><a href="#" class="RemoveFileField">&times;</a></div>');
            x++; //text box increment
        }
return false;
});
//delete input
$("body").on("click",".RemoveFileField", function(e){ //user click on remove text
        if( x > 1 ) {
                $(this).parent('div').remove(); //remove text box
                x--; //decrement textbox
                FieldImageCount--;
        }
return false;
}) 

//-------------------------------- this is for add set feild  -------------------------------------------------------//
var FieldCount=0; //to keep track of text box added
var SetInputsWrapper   = $("#PasteField"); //Input boxes wrapper ID
var AddField       = $("#AddField"); //Add button ID
var x = SetInputsWrapper.length; //initlal text box count


$(AddField).click(function (e)  //on add input button click
{
        if(x <= MaxInputs) //max input box allowed
        {
            FieldCount++; //text box added increment
            $('input:hidden[name="set_feild_count"]').attr('value',FieldCount+1);
            
            var field = '<div class="form-group"><label>Location Name</label><input type="text" class="form-control" name="location_name_'+FieldCount+'" required /></div> <div class="form-group"><label>Location Detail</label><textarea rows="4" cols="50" class="form-control" name="article_detail_'+FieldCount+'" required ></textarea></div> <div class="form-group"><label>Upload Location Image</label><input type="file" class="form-control" name="data[ArticleImage_'+FieldCount+'][]" multiple required ></div>';

            //add input box
            $(SetInputsWrapper).append('<div id="'+FieldCount+'">'+field+'<a href="#" class="removeclass">&times;</a></div>');
            x++; //text box increment
        }
return false;
});

$("body").on("click",".removeclass", function(e){ //user click on remove text
        if( x > 1 ) {
                $(this).parent('div').remove(); //remove text box
                x--; //decrement textbox
                FieldCount--;
                $('input:hidden[name="set_feild_count"]').attr('value',FieldCount+1);
                
        }
return false;
}) 


});

/*
function AddFileField(id){
	
	var FieldImageCount = 1; //to keep track of text box added		
	var MaxInputs       = 8; //maximum input boxes allowed
	var InputsWrapper   = $("#TestFile"+id+" "); //Input boxes wrapper ID
	console.log(InputsWrapper);

	if(x <= MaxInputs) //max input box allowed
    {
	        	FieldImageCount++; //text box added increment
	            //add input box
	            $(InputsWrapper).append('<div><input type="file" name="field_'+FieldImageCount+'" id="field_'+ FieldImageCount +'" value="Text '+ FieldImageCount +'"/><a href="#" class="RemoveFileField">&times;</a></div>');
	            x++; //text box increment
    }
	
	//delete input
	$("body").on("click",".RemoveFileField", function(e){ //user click on remove text
	        if( x > 1 ) {
	                $(this).parent('div').remove(); //remove text box
	                x--; //decrement textbox
	                FieldImageCount--;
	        }
	        
}
*/
