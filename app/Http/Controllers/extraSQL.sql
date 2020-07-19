alter table customers add daysToBlock int(3) default 100;

alter table customers add maxDebt int(9) default 100000;

alter table customers add blockReason varchar(300) null;

alter table debts add new_total_debt double null;


alter table users add threshold int(11) ;