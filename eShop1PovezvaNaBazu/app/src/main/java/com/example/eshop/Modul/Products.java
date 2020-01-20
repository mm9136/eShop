package com.example.eshop.Modul;

public class Products {
    private  String product_id,name,price,description,/*image,*/active;

    public Products(String product_id, String name, String price, String description,/* String image,*/ String active) {
        this.product_id = product_id;
        this.name = name;
        this.price = price;
        this.description = description;
        //this.image = image;
        this.active = active;
    }

    public String getProduct_id() {
        return product_id;
    }

    public void setProduct_id(String product_id) {
        this.product_id = product_id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getPrice() {
        return price;
    }

    public void setPrice(String price) {
        this.price = price;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }
/*
    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }
*/
    public String getActive() {
        return active;
    }

    public void setActive(String active) {
        this.active = active;
    }
}
