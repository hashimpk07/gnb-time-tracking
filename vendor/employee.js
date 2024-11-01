$(document).ready(function(){
	$("#save").click(saveData);
	$("[name='employee']").click(function(){
		mode = "insert";
		$("[name='name']").val("");
		$("#save").attr("value", "New Employee Add");
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
	var name;
    var teams;
	
	function getValue(){
		data = new FormData();
		name = $("[name='name']").val();
        teams = $("[name='teams']").val();
		data.append("mode", mode);
		data.append("id", idTarget);
		data.append("name", name);
        data.append("teams_id", teams);
		
	}

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

	function insertData(){
		$('#loading').show();
		getValue();
		$.post({
			url : "../controller/employee.php",
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
			url : "../controller/employee.php",
			data : {mode:'loadOne', id:idTarget},
			success : function(data){
				var temp = JSON.parse(data);
				$("[name='name']").val(temp.name);
                $("[name='teams']").val(temp.teamName);
			}
		});
        
		$.get({
			url : "../controller/teamCategory.php",
			data : {mode:"loadOne", id:idTarget},
			success : function(data){
				$("[name='teams']").html(data);
				
			}
		});
	}

	function updateData(){
		$('#loading').show();
		getValue();
		$.post({
			url : "../controller/employee.php",
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
			url : "../controller/employee.php",
			data : {mode:'load'},
			success : function(data){
				$("body table tbody").html(data);
			}
		});

        $.get({
			url : "../controller/teamCategory.php",
			data : {mode:"loadAll"},
			success : function(data){
				$("[name='teams']").html(data);
				
			}
		});
		clearForm();
	};

	function deleteData(id){
		$('#loading').show();
		$.get({
			url : "../controller/employee.php",
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
        $("[name='teams']").val("");
		data = new FormData();
		mode = "insert";
		$("#save").attr("value", "New Employee Add");
		idTarget = -1;
	}
})