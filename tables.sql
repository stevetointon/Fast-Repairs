DROP Table CustomerBill;
DROP TABLE RepairLog;
DROP Table RepairJob;
DROP Table contractItems;
DROP Table ServiceContract;
DROP Table ProblemReport;
DROP Table RepairItems;
DROP Table RepairPerson;
DROP Table Customers;

Create Table Customers(
	name VARCHAR(25), 
	phoneNo VARCHAR(15),
	PRIMARY KEY (phoneNo)
);

Create Table RepairPerson(
	empNo integer PRIMARY KEY,	
	name VARCHAR(25),	
	phoneNo VARCHAR(15)
);

Create Table RepairItems
(
	itemId integer  PRIMARY KEY,
	itemtype VARCHAR(10) CHECK(itemtype in('Computer','Printer')), 
	model VARCHAR(20), 
	price numeric(7,2), 
	year integer, 
	serviceContractType VARCHAR(7) CHECK(serviceContractType in('NONE','SINGLE','GROUP'))
);

Create Table ProblemReport(
	itemId integer,
	problemCode integer,
	foreign key(itemId) references RepairItems(itemId)
);

Create Table ServiceContract(
	contractId VARCHAR(5) PRIMARY KEY, 
	name VARCHAR(25),
	phoneNo VARCHAR(15),	
	startDate date, 
	endDate date, 
	foreign key(phoneNo) references Customers(phoneNo)
);

Create Table contractItems
(
	contractId varchar(5),
	machineId varchar(20),
	foreign key (contractId) references serviceContract(contractId)
);



Create Table RepairJob(
	machineId integer,
	serviceContractId VARCHAR(5) DEFAULT NULL,
	arrivalTime date,
	name VARCHAR(25), 
	phoneNo VARCHAR(15),
	empNo integer,
	status VARCHAR(15) CHECK(status in('UNDER_REPAIR','READY','DONE')),
	foreign key(machineId) references RepairItems(itemId),
	foreign key(phoneNo)references Customers(phoneNo),	
	foreign key(empNo) references repairPerson(empNo)
);


CREATE TABLE RepairLog(
	machineId integer,
	serviceContractId VARCHAR(5),
	arrivalTime date,
	name VARCHAR(25),
	phoneNo VARCHAR(15),
	departureTime date,
	foreign key (serviceContractId) references ServiceContract(contractId),
	foreign key (machineId) references RepairItems(itemId),
	foreign key (phoneNo) references Customers(phoneNo)
);



--- 50 dolars for service + cost of parts + (l)abor hours * 20) = amount charged 
Create Table CustomerBill(
	machineId integer,
	name VARCHAR(25),
	phoneNo VARCHAR(15),	
	timeIn date,
	timeOut date,
	problemIds VARCHAR(5),
	repairPersonId  integer,
	laborHours integer,
	costOfParts numeric(7,2),
	amountCharged integer,
	foreign key(machineId) references RepairItems(itemId),
	foreign key(repairPersonId) references RepairPerson(empNo),
	foreign key(phoneNo) references Customers(phoneNo)
);



insert into customerBill values (1, 'Asa','(408)420-7330', TO_DATE('2018/02/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'), TO_DATE('2020/05/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'),'test', 1, 10, 30,50);
--list of triggers to add
	--trigger to insert the time/date in when machine is added(for acceptMachine)
	--time out when updated to done status
	--trigger to update the laborhours depending on whether the repair job already exists
	--

insert into repairPerson values(1,'Russell Westbrook', '(690)696-6969');
insert into repairPerson values(2, 'Kevin Durant', '(420)420-4200');
insert into repairPerson values(3, 'Michael Jordan', '(232)232-2323');
insert into repairPerson values(4, 'Bugs Bunny', '(123)456-7890');
insert into repairPerson values(5, 'Daffy Duck', '(987)654-3210');

insert into customers values('Asa Jacob', '(408)420-7330');
insert into customers values('Steve Tointon','(303)552-7157');

insert into ServiceContract values('a','Asa Jacob','(408)420-7330', TO_DATE('2018/02/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'), TO_DATE('2020/05/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'));
insert into contractItems values ('a','Macbox');
insert into ServiceContract values('b','Steve Tointon','(303)552-7157', TO_DATE('2016/02/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'), TO_DATE('2017/05/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'));
insert into	contractItems values('b','PCbox');
insert into contractItems values('b','prntr');


insert into repairItems values(1, 'Computer','Mac', 1000, 2017, 'NONE');
insert into repairItems values(2, 'Computer','Mac', 1000, 2017, 'NONE');

insert into repairJob values(1,	NULL, TO_DATE('2018/02/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'), 'Asa', '(408)420-7330', 1, 'READY');
insert into repairJob values(2,	NULL, TO_DATE('2018/02/03 21:02:44', 'yyyy/mm/dd hh24:mi:ss'), 'Asa', '(408)420-7330', 1, 'UNDER_REPAIR');


