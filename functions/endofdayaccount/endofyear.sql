create table endofyear_tb (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    int_id int(11) not null,
    branch_id int(11) not null,
    staff_id int(11) not null,
    manual_posted int(11) not null,
    closed_date varchar(256) not null,
    year varchar(256) not null,
    created_on datetime default NOW()
 )