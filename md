Software Requirements Specification (SRS)
Project: MUST Online Voting System
Prepared by: Christina & Elia
# Software Requirements Specification (SRS)
## Project: MUST Online Voting System
## Prepared by: Christina & Elia
1. Introduction
1.1 Purpose
This document describes the requirements for the MUST Voting System. The system allows students of Mbeya University of Science and Technology (MUST) to vote for leaders online in a secure and easy way.
1.2 Scope
The system will:
•	Allow students to log in and vote.
•	Let each student vote only once for up to two leaders.
•	Allow a committee to add leaders, update or delete them, and view voting results.
•	Be used on mobile phones and computers.
1.3 Definitions
•	**Student:** A user who votes.
•	**Committee:** Users who manage the system.
•	**Leader:** A person who can be voted for.
2. System Overview
The system has three types of users:
1. **Student:** Logs in and votes.
2. **Committee (Add):** Adds, updates, or deletes leaders.
3. **Committee (Result):** Views results.
3. Functional Requirements
3.1 Student Login
•	Must enter a registration number like 231005333500X and password.
•	Can vote only once.
3.2 Voting
•	Student can choose up to 2 leaders.
•	After voting, student is logged out.
•	Same student cannot vote again.
3.3 Committee Login
•	Committee uses special login credentials.
•	There are two roles:
•	Add/Manage Leaders
•	View Results
3.4 Add/Update/Delete Leader
•	Committee can add, edit, or remove a leader including name, description, and image.
3.5 View Results
•	Committee can see vote count for each leader.
•	The leader(s) with the highest votes are shown as winners.
3.6 Logout
•	Any user can log out and return to login page.
4. Non-Functional Requirements
4.1 Usability
•	Easy to use interface for students and committee.
4.2 Security
•	A student can vote only once.
•	Login required for all actions.
4.3 Performance
•	Should work well on slow internet.
•	Fast login and vote submission.
4.4 Compatibility
•	Must work on phones, tablets, and computers.
4.5 Maintainability
•	Code and database should be simple and easy to update.
5. Technology Used
•	HTML, CSS, JavaScript
•	PHP
•	MySQL Database
6. Assumptions
•	All students have unique registration numbers.
•	All students use the same password (for simplicity).
•	Committee users have fixed login details.
7. Future Improvements
•	Add password encryption.
•	Allow voting for different categories.
•	Send confirmation email after voting.
•	Prevent voting from the same device twice.
•	Record voting time.
8. Approval
**Prepared by:** Christina & Elia
**Course:** Bachelor of Science in Computer Engineering
**Institution:** Mbeya University of Science and Technology
