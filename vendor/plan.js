$(document).ready(function(){
	$("#save").click(saveData);
	$("[name='employee']").click(function(){
		mode = "insert";
		$("[name='name']").val("");
		$("#save").attr("value", "New Plan Add");
	})
	$("body").on("click", ".edit", function(){
		mode = "update";
		$("#save").attr("value", "Edit");
		idTarget = $(this).attr("data-id");
		getData(idTarget);
	});
	$("body").on("click", ".delete", function(){
		idTarget = $(this).attr("data-id");
		var temp = confirm("Are you sure?");
		if(!temp){
			return false;
		}else{
			deleteData(idTarget);
		}
	});
	loadData();

	function saveData(){
		getValue();
		if(name == ""){
			alert("Please enter employee name");
		}else if(teams==-1){
			alert("Please selected catehory!");
		}else{
			if(mode=="insert"){
				insertData();
			}else if(mode=="update"){
				updateData();
			}
		}
	};

   
	function loadData(){
        $.get({
			url : "../controller/plan.php",
			data : {mode:"loadAll"},
			success : function(data){
				$("[name='weeks']").html(data);
				
			}
		});
		
	};

	

	function clearForm(){
		$("[name='name']").val("");
        $("[name='teams']").val("");
		data = new FormData();
		mode = "insert";
		$("#save").attr("value", "New Employee Add");
		idTarget = -1;
	}
})