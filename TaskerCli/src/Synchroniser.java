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
	public ArrayList<Task> synchroniseTasks(ArrayList<Task> offlineTasks)/*throws ...*/{
		//Contains the list of synchronised tasks
		ArrayList<Task> correctTasks = new ArrayList<Task>();
		//Attempt to make contact with the server
		ArrayList<Task> onlineTasks = retrieveFromSever(employeeEmail);	
		//If we could contact the database
		
		if(onlineTasks != null){
			if(offlineTasks != null){
			//^^IF we have 2 lists of tasks, one offline one online
				
				//Loop through each retrieved task
				for(int i = 0; i < onlineTasks.size(); i++){
					Task onlineTask = onlineTasks.get(i);
					
					//If the task in question appears in the offline list also
					if(offlineTasks.contains(onlineTask)){
						//Find the offline equivalent
						Task offlineTask = offlineTasks.get(offlineTasks.indexOf(onlineTask));
						
						//Online deletions take precedence 
						if(onlineTask.getStatus() != Status.ALLOCATED){
							correctTasks.add(onlineTask);
						}else{
							//Local updates task precedence
							correctTasks.add(offlineTask);
						}
					}else{
						//It must be new,add it to the list of synchronised tasks
						correctTasks.add(onlineTask);
					}
				}
			}else{
			//^^We only have the online tasks, must assume correct
				correctTasks = onlineTasks;
			}
			
			//In either case we can now save to the sever
			saveToLocal(correctTasks);
			saveToSvr(correctTasks);
		}else{
		//^^We only have the offline tasks
			if(offlineTasks != null){
				correctTasks = offlineTasks;
			}else{
				correctTasks = null;
			}
			
			//We can save locally but not to the sever at this point
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
		
		//Where we store the tasks we are receiving
		ArrayList<Task> retrievedTasks = new ArrayList<Task>();
		
		//Connect to the database using the given id and password
        String driver = "com.mysql.jdbc.Driver";
		String url = "jdbc:mysql://db.dcs.aber.ac.uk/csgp_7_15_16";
        String user = "csgpadm_7";
        String password = "Tbart8to";
        Connection connect = null;
        java.sql.Statement statement = null;
        ResultSet resultSet = null;
        
        //The names of the column headings in the database for my own reference
        //Task: title, startDate, ecd, status, memberEmail
        //TaskElement: elementID, taskID, description
        //ElementComment: commentID, taskElementID, content
        
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
        		//Temporarily stores the elements for the current task being read
        		ArrayList<String> elements = new ArrayList<String>();
        		//Temporarily stores the comments for the current task being read
        		ArrayList<String> comments = new ArrayList<String>();
        		//The converted arraylist to array for the elements and comments
        		String[] finalElements;
        		String[] finalComments;
        		
        		//Get all of the general task info
            	int taskID = rs.getInt("taskID");
            	String title = rs.getString("title");
                String startDate = rs.getString("startDate");
                String endDate = rs.getString("ecd");
                Status status = Status.stringToStatus(rs.getString("status"));
                String email = rs.getString("memberEmail");
             
                //Query the elements table to get all of the task elements
                Statement eStatement = connect.createStatement();
                ResultSet elementSet = eStatement.executeQuery("SELECT * FROM TaskElement WHERE taskID='"+taskID+"'");
                
                //Extract the elements and related comments
                while(elementSet.next()){
                	int elementID = elementSet.getInt("elementID");
                	
                	//Get the element
                	String element = elementSet.getString("description");
                	elements.add(element);
                	
                	//Get the comment
                	Statement rStatement = connect.createStatement();
                	ResultSet commentSet = rStatement.executeQuery("SELECT * FROM ElementComment WHERE taskElementID='"+elementID+"'");
                	while(commentSet.next()){
                		String comment = commentSet.getString("content");
                		comments.add(comment);
                	}
                	commentSet.close();
                	rStatement.close();
                }
                
                //Make the new task
                finalElements = elements.toArray(new String[elements.size()]);
                finalComments = comments.toArray(new String[comments.size()]);
                Task newTask = new Task(taskID, title, email, status, finalElements, finalComments, tasker);
                retrievedTasks.add(newTask);
                
                eStatement.close();
                elementSet.close();
            }
            
            // Close connection
            rs.close();
            stmt.close();
            connect.close();
        
        // Catch and print problems to the console
        } catch (Exception e) {
            System.out.println("Something went wrong loading from sever.");
            System.out.println(e.getMessage());
            return null;
        }    

		return retrievedTasks;
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
		//UPDATE mytable SET foo='bar', baz='bat' WHERE id=12
		
		//Connect to the database using the given id and password
        String driver = "com.mysql.jdbc.Driver";
		String url = "jdbc:mysql://db.dcs.aber.ac.uk/csgp_7_15_16";
        String user = "csgpadm_7";
        String password = "Tbart8to";
        Connection connect = null;
        java.sql.Statement statement = null;
        ResultSet resultSet = null;
        
        //The names of the column headings in the database for my own reference
        //Task: title, startDate, ecd, status, memberEmail
        //TaskElement: elementID, taskID, description
        //ElementComment: commentID, taskElementID, content
        
        System.out.println("About to attempt to establish database connection.");
        try {
            System.out.println("Registering driver");
        	// Register driver
            Class.forName(driver);
            System.out.println("Connecting...");
            connect = DriverManager.getConnection(url, user, password);
            System.out.println("Connected!");
            
            //loop for each task
            for(int i = 0; i < tasks.size(); i++){
            	Task theTask = tasks.get(i);
            	
            	//Update the tasks status in the database
            	PreparedStatement preparedStmt = connect.prepareStatement("UPDATE Task SET status='"+theTask.getStatus()+"'WHERE taskID='"+theTask.getID()+"';");
                preparedStmt.executeUpdate();
                preparedStmt.close();
            	
                //The comments to save
            	String[] comments = theTask.getComments();
            	//The ID of the elements that there are comments on
            	int[] elementIDs = new int[comments.length];
            	
            	//Query the elements table to get all of the task element ID's relevant for this task
            	//This allows us to then edit the comments with the relevant element ID's
                Statement eStatement = connect.createStatement();
                ResultSet elementSet = eStatement.executeQuery("SELECT * FROM TaskElement WHERE taskID='"+theTask.getID()+"'");
                int j = 0;
                while(elementSet.next()){
                	elementIDs[j] = elementSet.getInt("elementID");
                	j++;
                }
                eStatement.close();
                elementSet.close();
            
            	//Loop through each elementID
                for(j = 0; j < elementIDs.length; j++){
                	//Update the comment with the given elementID in the database
                	preparedStmt = connect.prepareStatement("UPDATE ElementComment SET content='"+comments[j]+"'WHERE taskElementID='"+elementIDs[j]+"';");
                    preparedStmt.executeUpdate();
                    preparedStmt.close();
                }
            }
            
            connect.close();
        
        // Catch and print problems to the console
        } catch (Exception e) {
            System.out.println("Something went wrong saving to server.");
            System.out.println(e.getMessage());
        }    
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
				//The tasks ID
				int ID;
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
				ID = infile.nextInt();
				infile.nextLine();
				title = infile.nextLine();
				readStatus = infile.nextLine(); 
				//Read the start date
				//Read the complete date
				
				//Allocate the status based on the string
				if(readStatus.substring(0, 2).equals("al")){
					status = Status.ALLOCATED;
				}else if(readStatus.substring(0, 2).equals("ab")){
					status = Status.ABANDONED;
				}else{
					status = Status.COMPLETED;
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
				task = new Task(ID, title, employeeEmail, status, elements, comments, tasker);
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
