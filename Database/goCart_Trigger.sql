CREATE OR REPLACE TRIGGER  Admin_Id_Trg
            before insert on Admin
            for each row
                begin
            if :new.Admin_Id is null then
                select Admin_Id_seq.nextval into :new.Admin_Id from dual;
            end if;
            end;

            
CREATE OR REPLACE TRIGGER  Customer_Id_Trg
            before insert on Customer
            for each row
                begin
            if :new.Customer_Id is null then
                select Customer_Id_seq.nextval into :new.Customer_Id from dual;
            end if;
            end;

            CREATE OR REPLACE TRIGGER  Order_Id_Trg
            before insert on Orders
            for each row
                begin
            if :new.Order_Id is null then
                select Order_Id_seq.nextval into :new.Order_Id from dual;
            end if;
            end;

       

            CREATE OR REPLACE TRIGGER  Product_Id_Trg
            before insert on Product
            for each row
                begin
            if :new.Product_Id is null then
                select Product_Id_seq.nextval into :new.Product_Id from dual;
            end if;
            end;


            CREATE OR REPLACE TRIGGER  Review_Id_Trg
            before insert on Review
            for each row
                begin
            if :new.Review_Id is null then
                select Review_Id_seq.nextval into :new.Review_Id from dual;
            end if;
            end;


            CREATE OR REPLACE TRIGGER  Shop_Id_Trg
            before insert on Shop
            for each row
                begin
            if :new.Shop_Id is null then
                select Shop_Id_seq.nextval into :new.Shop_Id from dual;
            end if;
            end;


            CREATE OR REPLACE TRIGGER  Time_Slot_Id_Trg
            before insert on Time_Slot
            for each row
                begin
            if :new.Time_Slot_Id is null then
                select Time_Slot_Id_seq.nextval into :new.Time_Slot_Id from dual;
            end if;
            end;

            CREATE OR REPLACE TRIGGER  Trader_Id_Trg
            before insert on Trader
            for each row
                begin
            if :new.Trader_Id is null then
                select Trader_Id_seq.nextval into :new.Trader_Id from dual;
            end if;
            end;

            CREATE OR REPLACE TRIGGER  Cart_Id_Trg
            before insert on Cart
            for each row
                begin
            if :new.Cart_Id is null then
                select Cart_Id_seq.nextval into :new.Cart_Id from dual;
            end if;
            end;