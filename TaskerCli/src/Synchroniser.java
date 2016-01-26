import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import java.util.InputMismatchException;
import java.util.Scanner;
import java.sql.*;

/**
 * 
 * Provides all of the loading, synchronising and saving 
 * functionality of the program.
 * 
 * @author Group 07: kuh1, ...
 * @version 0.2
 * @date 28/11/2015
 */
public class Synchroniser {
	
	private String employeeEmail;
	private TaskerCli tasker;
	private String fileName;
	
	/**
	 * Creates a new synchroniser for the input user.
	 * @param userEmail
	 * 				The email of the user logging in.
	 * @param mainProgram
	 * 				A reference to the main program.
	 */
	public Synchroniser(String userEmail, TaskerCli mainProgram){
		employeeEmail = userEmail;
		tasker = mainProgram;
		//Either just use one file name or come up with a better system e.g. loop until a char not in the set{<a-b,A-B,0-9>} appears.
		fileName = userEmail.substring(0, 3) + ".txt";
	}
	
	/**
	 * Synchronises the input array of tasks with the tasks on taskerCli.
	 * Once a correct array of tasks has been produced it calls this.saveToLocal 
	 * and this.saveToSvr. If synchronisation failed only save to local.
	 *
	 * @param currentTasks
	 * 				The local copy of the users tasks.
	 * @return
	 * 				The new up to date version of the users task after 
	 * 				synchronisation, or the input list of tasks if the
	 * 				sever can't be contacted.
	 * 
	 * @throws NoTaskException: Email address found on TaskerSvr but no tasks
	 * 		stored locally or online
	 * @throws InvalidEmailException: No task or user data locally or online.
	 */
	public ArrayList<Task> synchroniseTasks(ArrayList<Task> currentTasks)/*throws ...*/{
		ArrayList<Task> correctTasks = new ArrayList<Task>();
		
		//Attempt to make contact with the server
		correctTasks = retrieveFromSever(employeeEmail);
		
		//If we could contact the database
		if(correctTasks != null){
			
			//Sync code e.g. local updates have priority
		
			saveToLocal(correctTasks);
			saveToSvr(correctTasks);
		}else{
			//There isnt anything to do but save to local storage
			correctTasks = currentTasks;
			saveToLocal(correctTasks);
		}
		
		return correctTasks;
	}
	
	/**
	 * Retrieve the list of tasks marked 'allocated' for the user from TaskerSvr
	 * @return
	 * 		The list of tasks or null of none found/no connection made
	 */
	private ArrayList<Task> retrieveFromSever(String employeeEmail){
		 
        String driver = "com.mysql.jdbc.Driver";
		String url = "jdbc:mysql://db.dcs.aber.ac.uk/csgp_7_15_16";
        String user = "csgpadm_7";
        String password = "Tbart8to";
        Connection connect = null;
        java.sql.Statement statement = null;
        ResultSet resultSet = null;
                
        
        System.out.println("About to attempt to establish database connection.");
        try {
            System.out.println("Registering driver");
        	// Register driver
            Class.forName(driver);
            System.out.println("Connecting...");
            connect = DriverManager.getConnection(url, user, password);
            System.out.println("Connected!");
            Statement stmt = connect.createStatement();
            ResultSet rs = stmt.executeQuery("SELECT * FROM Task WHERE memberEmail='"+employeeEmail+"'");
            // Extract data from resultSet (fix field name)
            while (rs.next()) {
            	String name = rs.getString("title");
                System.out.println(name);
            }
            
            // Close connection
            rs.close();
            stmt.close();
            connect.close();
        
        // Catch and print problems to the console
        } catch (Exception e) {
            System.out.println("Something went wrong.");
            System.out.println(e.getMessage());
        }    

		return null;
	}
	
	/**
	 * Saves the input list of tasks into local storage, creating a file called,
	 * <abc>.txt where <abc> is the first 3 characters of the users email.
	 * @param tasks
	 * 			The list of tasks to save.
	 */
	private void saveToLocal(ArrayList<Task> tasks){
		if(tasks == null){
			return;
		}
		
		//Create a file writer
		try(FileWriter fw = new FileWriter(fileName);
			BufferedWriter bw = new BufferedWriter(fw);
			PrintWriter outfile = new PrintWriter(bw);){
				
			//Output user email on the first line
			outfile.println(employeeEmail);
			//Output Number of tasks on the second
			outfile.println(tasks.size());
			//Output each tasks details in the rest of the document
			for(int i = 0; i < tasks.size(); i++){
				tasks.get(i).saveInfo(outfile);	
			}

		} catch (IOException e) {
			System.err.println("Problem when trying to write to file: " + fileName);
		}
	}
	
	/**
	 * Saves the input list of tasks to TaskerSvr.
	 * @param tasks
	 * 			The list of tasks to save.
	 */
	private void saveToSvr(ArrayList<Task> tasks){
		//To be implemented
	}
	
	/**
	 * Loads the relevant tasks (only those for the input user) from 
	 * local storage into an array of task objects. Should only really
	 * be called once per user per program run.
	 * @return
	 * 		An array list of the tasks that are assigned to the input
	 * 		user, or null of no tasks found.
	 */
	public ArrayList<Task> retrieveTasksFromLocal(){
		ArrayList<Task> tasks = new ArrayList<Task>();
	
		//Try to read from the users file
		try(FileReader fr = new FileReader(fileName);
			BufferedReader br = new BufferedReader(fr);
			Scanner infile = new Scanner(br)){
			
			//The email stored in the file
			String foundEmail;
			//The amount of tasks stored
			int noTasks;
			//The amount of elements stored for the task being read
			int noElements;
			
			foundEmail = infile.nextLine();
			//If the email's don't match return null as there is no task data for this user locally
			if(!employeeEmail.equals(foundEmail)){
				return null;
			}
			
			noTasks = infile.nextInt();
			infile.nextLine();
			//loop for each task
			for(int i = 0; i < noTasks; i++){
				Task task;
				//The tasks title
				String title;
				//The string read from the file for status
				String readStatus;
				//The status interpreted from the above string
				Status status;
				//The tasks elements and comments
				String[] elements;
				String[] comments;
				
				//Read the general task information
				title = infile.nextLine();
				readStatus = infile.nextLine(); 
				//Read the start date
				//Read the complete date
				
				//Allocate the status based on the string
				if(readStatus.substring(0, 2).equals("AL")){
					status = Status.ALLOCATED;
				}else if(readStatus.substring(0, 2).equals("AB")){
					status = Status.ABANDONED;
				}else{
					status = Status.COMPLETE;
				}
				
				//Read the amount of elements and initialise the arrays
				noElements = infile.nextInt();
				infile.nextLine();
				elements = new String[noElements];
				comments = new String[noElements];
				
				//loop to store the elements and comments
				for(int j = 0; j < noElements; j++){
					elements[j] = infile.nextLine();
					comments[j] = infile.nextLine();
				}
				
				//Create a new tasks with this information
				task = new Task(title, employeeEmail, status, elements, comments, tasker);
				tasks.add(task);
			}
			
		//Catch the various possible errors, such as the user not having a file
		} catch (FileNotFoundException e) {
			System.err.println("Load error 1");
			return null;
		} catch (IOException e) {
			System.err.println("Load error 2");
			return null;
		} catch (InputMismatchException e) {
			System.err.println("Load error 3");
			return null;
		}
		
		return tasks;
	}
	
	/*
	private void invokeSynchronise(ArrayList<Task> tasks)
	 */
}
