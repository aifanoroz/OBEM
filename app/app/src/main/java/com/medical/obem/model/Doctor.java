package com.medical.obem.model;

public class Doctor {
    private String name;
    private String Specialization;



    private String key;

    public Doctor(String name, String Specialization,String key) {
        this.name = name;
        this.Specialization = Specialization;
        this.key=key;
    }
    public Doctor() {
    }
    public String getKey() {
        return key;
    }

    public void setKey(String key) {
        this.key = key;
    }

    public String toString(){
        return name+" ("+Specialization.toUpperCase()+")";
}

    public String getSpecialization() {
        return Specialization;
    }

    public void setSpecialization(String specialization) {
        Specialization = specialization;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }





}

