$(document).ready(function(){
	$("#save").click(saveData);
	$("[name='team']").click(function(){
		mode = "insert";
		$("[name='name']").val("");
		$("#save").attr("value", "New Teams Add");
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

	var mode = "insert";
	var idTarget = -1;

	var data;
	var teamName;
	
	function getValue(){
		data = new FormData();
		name = $("[name='name']").val();
		data.append("mode", mode);
		data.append("id", idTarget);
		data.append("name", name);
		
	}

	function saveData(){
		getValue();
		if(teamName == ""){
			alert("Please enter teams name");
		}else{
			if(mode=="insert"){
				insertData();
			}else if(mode=="update"){
				updateData();
			}
		}
	};

	function insertData(){
		$('#loading').show();
		getValue();
		$.post({
			url : "../controller/teams.php",
			data : data,
			contentType : false, 
			processData: false, 
			success : function(){
				loadData();
			},
			complete : function(){
				$('#loading').hide();
			}
		});
	}

	function getData($id){
		$.get({
			url : "../controller/teams.php",
			data : {mode:'loadOne', id:idTarget},
			success : function(data){
				var temp = JSON.parse(data);
				$("[name='name']").val(temp.name);
			}
		});
	}

	function updateData(){
		$('#loading').show();
		getValue();
		$.post({
			url : "../controller/teams.php",
			data : data,
			contentType : false, 
			processData: false, 
			success : function(){
				loadData();
				clearForm();
			},
			complete : function(){
				$('#loading').hide();
			}
		});
	}

	function loadData(){
		$.get({
			url : "../controller/teams.php",
			data : {mode:'load'},
			success : function(data){
				$("body table tbody").html(data);
			}
		});
		clearForm();
	};

	function deleteData(id){
		$('#loading').show();
		$.get({
			url : "../controller/teams.php",
			data : {mode:"delete", id:idTarget},
			success : function(){
				loadData();
				clearForm();
			},
			complete : function(){
				$('#loading').hide();
			}
		});
	}

	function clearForm(){
		$("[name='name']").val("");
		data = new FormData();
		mode = "insert";
		$("#save").attr("value", "New Teams Add");
		idTarget = -1;
	}
})