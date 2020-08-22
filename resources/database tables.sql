-- Database Name = 'mymoney'
-- username = 'root'
-- password = 'Msql4jbv191'
-- host = 'mysql:dbname=mymoney;host=127.0.0.1'


CREATE TABLE personal (
    userID int(6) AUTO_INCREMENT PRIMARY KEY,
    firstName varchar(255),
    lastName varchar(255),
   	birthDate date,
    userEmail varchar(255),
    userPassword varchar(255),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 

create table employment(
    jobID int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    companyName varchar(50),
    companyStreet varchar(50),
    companyCity varchar(50),
    companyState varchar(2),
    companyZip varchar(5),
    companyPhone varchar(20),
    companyStartDate date,
    companyEndDate date,
    userID int(6)
);

create table balance (
    balanceID int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    beginBalance decimal(8,2),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    userID int(6)
);

create table income(
    incomeID int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    incomeSource varchar(50),
    incomeDate date,
    incomeGross decimal(8,2),
    incomeNet decimal(8,2),
    incomeNote varchar(200),
    userID int(6)
);

create table account(
    accountID int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    accountCategory varchar(20),
    accountType varchar(20),
    accountName varchar(50),
    accountNumber varchar(50),
    accountStreet varchar(50),
    accountStreet2 varchar(50),
    accountCity varchar(50),
    accountState varchar(2),
    accountZip varchar(5),
    accountPhone varchar(20),
    accountBeginAmount decimal(8,2),
    accountPayment decimal(8,2),
    accountDueDate int(2),
    accountDueTime time,
    userID int(6)
);

create table payment(
    paymentID int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    paymentDate date,
    paymentTime time,
    paymentCategory varchar(20),
    paymentType varchar(20),
    paymentName varchar(50),
    paymentDescription varchar(200),
    paymentPaidAmount decimal(8,2),
    paidType varchar(20),
    accountID int(6),
    userID int(6)
);

create table contact(
    contactID int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    contactDate date,
    contactTime time,
    contactCategory varchar(20),
    contactName varchar(50),
    contactAccountType varchar(20),
    contactType varchar(20),
    contactResults varchar(20),
    contactNotes varchar(200),
    userID int(6)
);


-- Personal Data
insert into personal(firstName, lastName, birthDate, userEmail, userPassword)
values ('Jeremy', 'Vidal', '1977-10-17', 'jbvidal101@gmail.com', '1234');

-- Employment Data
insert into employment(companyName, companyStreet, companyCity, companyState, companyZip, companyPhone, companyStartDate, companyEndDate, userID)
values ('Ft Wayne Nissan','4909 Lima Rd', 'Ft Wayne', 'IN', '46808', '260-484-9500', '2020-02-24', NULL, 1);
insert into employment(companyName, companyStreet, companyCity, companyState, companyZip, companyPhone, companyStartDate, companyEndDate, userID)
values ('Arcane LLC', '6008 Moeller Rd Lot 92', 'Ft Wayne', 'IN', '46806' , '260-633-5157', NULL, NULL, 1);


-- Income Data
insert into income(incomeSource, incomeDate, incomeGross, incomeNet, incomeNote, userID)
values ('Ft Wayne Nissan', '2020-02-28', '750.00', '639.85', '', 1);
insert into income(incomeSource, incomeDate, incomeGross, incomeNet, incomeNote, userID)
values ('Ft Wayne Nissan', '2020-03-13', '1500.00', '1210.72', '', 1);
insert into income(incomeSource, incomeDate, incomeGross, incomeNet, incomeNote, userID)
values ('Ft Wayne Nissan', '2020-03-31', '1500.00', '1210.72', '', 1);
insert into income(incomeSource, incomeDate, incomeGross, incomeNet, incomeNote, userID)
values ('Ft Wayne Nissan', '2020-04-16', '1500.00', '1210.72', '', 1);

-- Account Data (Bills)
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Storage','Decatur Storage', 'A0128', 'P.O. Box 413', '', 'Decatur', 'IN', '46733' , '260-724-3373', 0, 65.00, 01, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Phone','ATT', '243019181920', 'P.O. Box 6416', '', 'Carol Stream', 'IL', '60197' ,'800-331-0500', 0, 111.81, 02, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Car Insurnace','Progressive', '932576944', '6300 Wilson Mills Rd', '', 'Mayfield Village', 'OH', '44143' ,'888-671-4405', 0, 61.51, 03, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Entertainment','Netflix', '', '', '', '', '', '' ,'', 0, 12.99, 11, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Guitar','Indiana Pawn Brokers', '', '3509 N Clinton St', '', 'Fort Wayne', 'IN', '46805' ,'260-484-5025', 0, 70.00, 15, str_to_date('9:00 AM','%l:%i %p'), 1);
-- Account Data (Collections)
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Collection', 'Judgement','Hawk, Hayne, Kammeyer & Smith', '', 'Lincoln Tower Suite 302', '116 East Berry Street', 'Fort Wayne', 'IN', '46802' ,'260-426-0770', 2230.42, 100.00, 01, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Collection', 'Judgement','Stuckey, Lauer & Young', '18186601', '127 West Berry St Suite 900', '', 'Fort Wayne', 'IN', '46802' ,'260-423-2646', 2272.60, 100.00, 16, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Collection', 'Loan','Eleven Fifty', '', '151 W Ohio St #170', '', 'Indianapolis', 'IN', '46204' ,'855-925-1150', 13500.00, NULL, NULL, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Collection', 'Previous','Christian', '', '155 Keller Dr', '', 'Greenfield', 'IN', '46140' ,'‭317-468-5172‬', 7000.00, NULL, NULL, str_to_date('9:00 AM','%l:%i %p'), 1);

-- May Payment Data 2020
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-05-01', '09:00', 'Collection', 'Judgement', 'Hawk, Hayne, Kammeyer & Smith', NULL, 100.00, 'In Person', 6, 1);
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-05-03', '09:00', 'Bill', 'Car Insurnace', 'Progressive', NULL, 61.50, 'Online', 3, 1);
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-05-04', '10:00', 'Bill', 'Storage', 'Decatur Storage', NULL, 65.00, 'Card', 1, 1);
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-05-02', '09:00', 'Bill', 'Phone', 'ATT', NULL, 111.81, 'Auto Pay', 2, 1);
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-05-05', '11:30', 'Living', 'Food', 'Arbys', NULL, 7.86, 'Card', NULL, 1);

-- April Payment Data 2020
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-04-01', '09:00', 'Collection', 'Judgement', 'Hawk, Hayne, Kammeyer & Smith', NULL, 100.00, 'In Person', 6, 1);
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-04-03', '16:00', 'Bill', 'Car Insurnace', 'Progressive', NULL, 61.50, 'Online', 3, 1);
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-04-04', '10:00', 'Bill', 'Storage', 'Decatur Storage', NULL,65.00, 'Card', 1, 1);
insert into payment(paymentDate, paymentTime, paymentCategory, paymentType, paymentName, paymentDescription, paymentPaidAmount, paidType, accountID, userID)
values ('2020-04-02', '13:00', 'Bill', 'Phone', 'ATT', NULL, 111.81, 'Auto Pay', 2, 1);

-- Contact Data
insert into contact(contactDate, contactTime, contactCategory, contactAccountType, contactName, contactType, contactResults, contactNotes, userID)
values ('2020-05-01', '11:30', 'Bill', 'Storage','Decatur Storage', 'Phone', 'Contacted', 'Paid bill over ther phone.', 1);
insert into contact(contactDate, contactTime, contactCategory, contactAccountType, contactName, contactType, contactResults, contactNotes, userID)
values ('2020-05-03', '10:00', 'Judgement', 'Collection', 'Stuckey, Lauer & Young', 'Email', 'Contacted', 'Discussed payment options.', 1);
insert into contact(contactDate, contactTime, contactCategory, contactAccountType, contactName, contactType, contactResults, contactNotes, userID)
values ('2020-05-04', '12:45', 'Guitar', 'Bill', 'Indiana Pawn Brokers', 'Phone', 'Voicemail', 'Left message.', 1);
insert into contact(contactDate, contactTime, contactCategory, contactAccountType, contactName, contactType, contactResults, contactNotes, userID)
values ('2020-05-04', '13:10', 'Loan', 'Collection', 'Eleven Fifty', 'Phone', 'Incoming', 'Just checking on my job situation.', 1);


drop table contact;
drop table payment;
drop table account;
drop table income;
drop table employment;
drop table personal;
drop table balance;




-- Extra Account Data ---- Dont Use These Yet!!!!
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Rent','Jennifer Vidal', '', '6008 Moeller Rd', 'Lot 92', 'Fort Wayne', 'IN', '46806' ,'260-348-0809', 0, 500.00, 1, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Electric','Indiana Michigan Power', '', '', '', 'Fort Wayne', 'IN', '' ,'800-311-4634', 0, 100.00, 0, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Gas(House)','Nipsco', '', '', '', 'Fort Wayne', 'IN', '' ,'800-464-7726', 0, 80.00, 0, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Water','City Utilities', '', '', '', 'Fort Wayne', 'IN', '' , '', 0, 75.00, 0, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Health Insurance','MHS', '102428056099', '', '', '', 'IN', '' , '877-6474848', 0, 100.00, 0, str_to_date('9:00 AM','%l:%i %p'), 1);
insert into account(accountCategory, accountType, accountName, accountNumber, accountStreet, accountStreet2, accountCity, accountState, accountZip, accountPhone, accountBeginAmount, accountPayment,accountDueDate, accountDueTime, userID)
values('Bill', 'Internet','Comcast', '', '', '', '', '', '' ,'', 0, 100.00, 0, str_to_date('9:00 AM','%l:%i %p'), 1);
