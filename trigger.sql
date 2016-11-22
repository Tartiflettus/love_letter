drop trigger trigger_joueurs;
delimiter |
create trigger trigger_joueurs before insert 
on joueurs for each row
begin
	declare nb_j int;
	
	select nb_joueurs into nb_j
	from jeu join joueurs using(num_partie)
	where num_partie = new.num_partie;
	
	if nb_j>=4 then
		signal sqlstate '45620'
		set message_text = 'Il y a déjà 4 joueurs!';
	end if;
end|
delimiter ;

