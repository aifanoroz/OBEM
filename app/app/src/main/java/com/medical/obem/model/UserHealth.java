package com.medical.obem.model;


public class UserHealth   {

    private String gender;
    private String tweight;
    private String height;
    private String weight;
    private String sweight;
    private String bsugar;
    private String systolic;
    private String diastolic;
    private Integer age;
    private String date;
    private String calorie;
    private String BMI;
    private String name;
    private String uid;



    public UserHealth() {

    }



    public String getUid() {
        return uid;
    }

    public void setUid(String uid) {
        this.uid = uid;
    }


    public String getBMI() {
        return BMI;
    }

    public void setBMI(String BMI) {
        this.BMI = BMI;
    }
    public String getCalorie() {
        return calorie;
    }

    public void setCalorie(String calorie) {
        this.calorie = calorie;
    }

    public String getSweight() {
        return sweight;
    }

    public void setSweight(String sweight) {
        this.sweight = sweight;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }


    public String getSystolic() {
        return systolic;
    }

    public void setSystolic(String systolic) {
        this.systolic = systolic;
    }

    public String getDiastolic() {
        return diastolic;
    }

    public void setDiastolic(String diastolic) {
        this.diastolic = diastolic;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
    public String getGender() {
        return gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public String getTweight() {
        return tweight;
    }

    public void setTweight(String tweight) {
        this.tweight = tweight;
    }

    public String getHeight() {
        return height;
    }

    public void setHeight(String height) {
        this.height = height;
    }

    public String getWeight() {
        return weight;
    }

    public void setWeight(String weight) {
        this.weight = weight;
    }

    public String getBsugar() {
        return bsugar;
    }

    public void setBsugar(String bsugar) {
        this.bsugar = bsugar;
    }

    public Integer getAge() {
        return age;
    }

    public void setAge(Integer age) {
        this.age = age;
    }


}
