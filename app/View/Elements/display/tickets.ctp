var url = "<?php echo $this->webroot.'customer_tickets/check_tickets';?>";
var ticketCount = $('div.ticket-count span');
var _display = "<?php echo ($this->view == 'tickets') ? 1 : 2;?>";                    
var fetchTickets = function()
{
	$.post(url,{display : _display },function(response)
	{        
		if( response.Result == "OK" )
		{
			for( var i in response.Objects)
			{                   
				if(!response.Objects[i].Ticket['Open'])
					response.Objects[i].Ticket['Open'] = 0
				if(!response.Objects[i].Ticket['OnProccess'])
					response.Objects[i].Ticket['OnProccess'] = 0
                var _target = $('#emp-'+response.Objects[i].User.id);    
                var ticketTarget = _target.find('div#tk-count'); 
                var ticketDone = _target.find('div#tk-done');         
                ticketTarget.find('span[class="tk-count"]').html(response.Objects[i].Ticket['Open']);
                ticketDone.find('span[class="tk-count"]').html(response.Objects[i].Ticket['OnProccess']);       
			}	                     
            for( var i in response.Quotes )
            {
                //console.log(response.Quotes[i].Quote);
                var _target = $('#emp-'+response.Quotes[i].Quote.sales_id+' div.quote-count'); 
                _target.html(response.Quotes[i].Quote.jml);                 
            }
		}
		else
		{
			$('#ticket-title').html('TODO Tickets '+response.Message);
		}
	},'json');
};
fetchTickets();   