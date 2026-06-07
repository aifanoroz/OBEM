package com.medical.obem.model;

public class DocReview {

    private String Bloodpressure;
    private String Bloodsugar;
    private String Weight;
    private String bmi;
    private String comment;

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    private String date;


    public DocReview() {

    }

    public DocReview(String bloodpressure, String bloodsugar, String weight, String bmi, String comment) {
        Bloodpressure = bloodpressure;
        Bloodsugar = bloodsugar;
        Weight = weight;
        this.bmi = bmi;
        this.comment = comment;
    }

    public String getBloodpressure() {
        return Bloodpressure;
    }

    public void setBloodpressure(String bloodpressure) {
        Bloodpressure = bloodpressure;
    }

    public String getBloodsugar() {
        return Bloodsugar;
    }

    public void setBloodsugar(String bloodsugar) {
        Bloodsugar = bloodsugar;
    }

    public String getWeight() {
        return Weight;
    }

    public void setWeight(String weight) {
        Weight = weight;
    }

    public String getBmi() {
        return bmi;
    }

    public void setBmi(String bmi) {
        this.bmi = bmi;
    }

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }


    public String toString(){
        return date;
    }

}
