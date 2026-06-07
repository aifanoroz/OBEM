package com.medical.obem.model;

public class Appointment {
    private String Username;
    private String Docname;
    private String uid;
    private String specialization;
    private String date;
    private String time;
    private int userStatus;
    private int doctorStatus;

    public int getUserStatus() {
        return userStatus;
    }

    public void setUserStatus(int userStatus) {
        this.userStatus = userStatus;
    }

    public int getDoctorStatus() {
        return doctorStatus;
    }

    public void setDoctorStatus(int doctorStatus) {
        this.doctorStatus = doctorStatus;
    }



    public String getDocname() {
        return Docname;
    }

    public void setDocname(String docname) {
        Docname = docname;
    }
    public String getSpecialization() {
        return specialization;
    }

    public void setSpecialization(String specialization) {
        this.specialization = specialization;
    }

    public String getName() {
        return Username;
    }

    public void setName(String name) {
        this.Username = name;
    }

    public String getUid() {
        return uid;
    }

    public void setUid(String uid) {
        this.uid = uid;
    }


    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getTime() {
        return time;
    }

    public void setTime(String time) {
        this.time = time;
    }




}
