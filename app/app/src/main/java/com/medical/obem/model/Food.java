package com.medical.obem.model;

public class Food {
    String Category;
    Long Calories;
    String Food;
    String Measure;

    public Food() {

    }

    public Food(String Category, long calories, String food, String Measure) {
        this.Category = Category;
        this.Calories = calories;
        this.Food = food;
        this.Measure=Measure;
    };



    public String getFood() {
        return Food;
    }

    public void setFood(String food) {
        Food = food;
    }

    public String getCategory() {
        return Category;
    }

    public void setCategory(String category) {
        Category = category;
    }


    public String getMeasure() {
        return Measure;
    }

    public void setMeasure(String measure) {
        Measure = measure;
    }



    @Override
    public String toString() {
        return Food+","+"\n"+Measure+"\n"+Calories+" Kcal";
    }



    public long getCalories() {
        return Calories;
    }

    public void setCalories(long calories) {
        this.Calories = calories;
    }
}


